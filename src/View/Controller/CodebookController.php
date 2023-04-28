<?php


namespace App\View\Controller;


use App\Domain\Model\Codebook\DatasetVariables;
use App\Domain\Model\Filemanagement\Dataset;
use App\Domain\Model\Study\MeasureMetaDataGroup;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use League\Csv\UnableToProcessCsv;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\Filesystem;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/codebook", name="codebook_")
 * @IsGranted("ROLE_USER")
 *
 * Class CodebookController
 * @package App\View\Controller
 */
class CodebookController extends AbstractController
{
    public function __construct(protected EntityManagerInterface $em, protected LoggerInterface $logger, private readonly Filesystem $filesystem)
    {
    }


    /**
     * @Route("/{uuid}", name="index")
     */
    public function codebookIndexAction(string $uuid): Response
    {
        return $this->render('Pages/Codebook/index.html.twig', [
            'codebook' => $this->em->getRepository(Dataset::class)->find($uuid),
        ]);
    }

    /**
     * @Route("/{uuid}/data", name="dataupdate")
     */
    public function performUpdateAction(string $uuid, Request $request): JsonResponse
    {
        $this->logger->debug("Enter CodebookController::performUpdateAction with [UUID: $uuid]");
        $dataset = $this->em->getRepository(Dataset::class)->find($uuid);
        if ($dataset && $request->isMethod("POST")) {
            $postedData = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
            $this->saveCodebookVariables($postedData);
        }
        $jsonCodebook = $this->codebookCollectionToJsonArray($dataset->getCodebook());

        return new JsonResponse($jsonCodebook, $jsonCodebook != null && sizeof($jsonCodebook) > 0 ? Response::HTTP_OK : Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/{uuid}/measures", name="measures")
     */
    public function createViewMeasuresAction(string $uuid): JsonResponse
    {
        $this->logger->debug("Enter CodebookController::createViewMeasuresAction with [UUID: $uuid]");
        $dataset = $this->em->getRepository(Dataset::class)->find($uuid);
        $viewMeasures = [];
        if ($dataset) {
            $measures = $this->em->getRepository(MeasureMetaDataGroup::class)->findOneBy(['experiment' => $dataset->getExperiment()]);
            if ($measures && $measures->getMeasures() && sizeof($measures->getMeasures()) > 0) {
                $viewMeasures = [];
                foreach ($measures->getMeasures() as $measure) {
                    if ($measure && "" != $measure) {
                        $viewMeasures['measures'][] = $measure;
                    }
                }
            }
        }

        return new JsonResponse($viewMeasures, key_exists('measures', $viewMeasures) ? Response::HTTP_OK : Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/{uuid}/matrix", name="matrix")
     */
    public function datasetMatrixAction(Request $request, string $uuid): JsonResponse
    {
        $size = $request->get('size') ?? 0;
        $page = $request->get('page') ?? 1;
        $this->logger->debug("Enter CodebookController::datasetMatrixAction with [UUID: $uuid]");
        $dataset = $this->em->getRepository(Dataset::class)->find($uuid);
        $response = null;
        if ($dataset) {
            foreach ($dataset->getCodebook() as $var) {
                $response['header'][] = $var->getName();
            }
        }
        if ($this->filesystem->has("matrix/".$uuid.".csv")) {
            try {
                $file = Reader::createFromString($this->filesystem->read("matrix/".$uuid.".csv"));
                if ($file->count() != 0) {
                    if (0 == $size) {
                        $response['content'] = $file;
                        $response['pagination']['max_items'] = $file->count();
                        $response['pagination']['items'] = $file->count();
                        $response['pagination']['current_page'] = 1;
                        $response['pagination']['max_pages'] = 1;
                    } else {
                        $min = 0 != $page ? ($page - 1) * $size : 0;
                        $max = $min + $size;
                        for ($count = $min; $count < $max; $count++) {
                            $response['content'][] = $file->fetchOne($count);
                        }
                        $response['pagination']['max_items'] = $file->count();
                        $response['pagination']['items'] = $size;
                        $response['pagination']['current_page'] = $page;
                        $response['pagination']['max_pages'] = ceil(0 != $file->count() ? ($file->count() / $size) : 0);
                    }
                } else {
                    $response['error'] = 'error.dataset.matrix.empty';
                }
            } catch (FileNotFoundException $e) {
                $this->logger->critical("FileNotFoundException in CodebookController::createViewMeasuresAction [UUID: $uuid] Exception: ".$e->getMessage());
                $response['error'] = 'error.dataset.matrix.notFound';
            } catch (UnableToProcessCsv $e) {
                $this->logger->critical("UnableToProcessCsv in CodebookController::createViewMeasuresAction [UUID: $uuid] Exception: ".$e->getMessage());
                $response['error'] = 'error.dataset.matrix.unprocessable';
            }
        }

        return new JsonResponse(
            $response,
            key_exists('error', $response) && !empty($response['error']) ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK
        );
    }

    private function codebookCollectionToJsonArray(?Collection $codebook): ?array
    {
        $jsonCodebook = null;
        if ($codebook && is_iterable($codebook)) {
            $jsonCodebook = [];
            foreach ($codebook as $var) {
                $jsonCodebook['variables'][] = [
                    "id" => $var->getVarId(),
                    "name" => $var->getName() ?? "",
                    "label" => $var->getLabel() ?? "",
                    "itemText" => $var->getItemText() ?? "",
                    "values" => $var->getValues() ?? [
                            [
                                "name" => "",
                                "label" => "",
                            ],
                        ],
                    "missings" => $var->getMissings() ?? [
                            [
                                "name" => "",
                                "label" => "",
                            ],
                        ],
                    "measure" => $var->getMeasure() ?? "",
                    "var_db_id" => $var->getId(),
                ];
            }
        }

        return $jsonCodebook;
    }

    private function saveCodebookVariables(array $arr)
    {
        if ($arr && is_iterable($arr) && key_exists('variables', $arr) && !empty($arr['variables']) && is_iterable($arr['variables'])) {
            foreach ($arr['variables'] as $variable) {
                if (key_exists("var_db_id", $variable)) {
                    $values = $variable["values"] ? $this->setMissingArrayFields(array_values(array_filter($variable["values"]))) : null;
                    $missings = $variable["missings"] ? $this->setMissingArrayFields(array_values(array_filter($variable["missings"]))) : null;
                    $var = $this->em->getRepository(DatasetVariables::class)->find($variable["var_db_id"]);
                    $var->setName($variable["name"] ?? $var->getName());
                    $var->setLabel($variable["label"] ?? null);
                    $var->setItemText($variable["itemText"] ?? null);
                    $var->setValues(null != $values && 0 != sizeof($values) ? $values : null);
                    $var->setMissings(null != $missings && 0 != sizeof($missings) ? $missings : null);
                    $var->setMeasure($variable["measure"] ?? null);
                    $this->em->persist($var);
                    $this->em->flush();
                }
            }
        }
    }

    private function setMissingArrayFields(?array $arr): ?array
    {
        if (null != $arr) {
            foreach ($arr as &$item) {
                if (key_exists('name', $item) && !key_exists('label', $item)) {
                    $item['label'] = '';
                }
                if (!key_exists('name', $item) && key_exists('label', $item)) {
                    $item['name'] = '';
                }
            }
        }

        return $arr;
    }

}
