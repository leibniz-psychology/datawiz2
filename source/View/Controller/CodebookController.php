<?php


namespace App\View\Controller;


use App\Domain\Model\Codebook\DatasetVariables;
use App\Domain\Model\Filemanagement\Dataset;
use App\Domain\Model\Study\MeasureMetaDataGroup;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
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
    protected EntityManagerInterface $em;
    protected LoggerInterface $logger;
    private Filesystem $filesystem;

    /**
     * @param EntityManagerInterface $em
     * @param LoggerInterface $logger
     * @param Filesystem $filesystem
     */
    public function __construct(EntityManagerInterface $em, LoggerInterface $logger, Filesystem $filesystem)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->filesystem = $filesystem;
    }


    /**
     * @Route("/{uuid}", name="index")
     *
     * @param string $uuid
     * @return Response
     */
    public function codebookIndexAction(string $uuid): Response
    {
        return $this->render('Pages/Codebook/index.html.twig', [
            'codebook' => $this->em->getRepository(Dataset::class)->find($uuid),
        ]);
    }

    /**
     * @Route("/{uuid}/data", name="dataupdate")
     *
     * @param string $uuid
     * @param Request $request
     * @return JsonResponse
     */
    public function performUpdateAction(string $uuid, Request $request): JsonResponse
    {
        $this->logger->debug("Enter CodebookController::performUpdateAction with [UUID: $uuid]");
        $dataset = $this->em->getRepository(Dataset::class)->find($uuid);
        if ($dataset && $request->isMethod("POST")) {
            $postedData = json_decode($request->getContent(), true);
            $this->saveCodebookVariables($postedData);
        }
        $jsonCodebook = $this->codebookCollectionToJsonArray($dataset->getCodebook());

        return new JsonResponse($jsonCodebook, $jsonCodebook != null && sizeof($jsonCodebook) > 0 ? Response::HTTP_OK : Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/{uuid}/measures", name="measures")
     *
     * @param string $uuid
     * @return JsonResponse
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
     *
     * @param string $uuid
     * @return JsonResponse
     */
    public function datasetMatrixAction(string $uuid): JsonResponse
    {
        $this->logger->debug("Enter CodebookController::createViewMeasuresAction with [UUID: $uuid]");
        $file = null;
        if ($this->filesystem->has("matrix/".$uuid.".json")) {
            try {
                $file = $this->filesystem->read("matrix/".$uuid.".json");
            } catch (FileNotFoundException $e) {
                $this->logger->critical("Exception in CodebookController::createViewMeasuresAction [UUID: $uuid] Exception: ".$e->getMessage());
            }
        }

        return new JsonResponse($file ? json_decode($file, true) : "", $file ? Response::HTTP_OK : Response::HTTP_NO_CONTENT);
    }

    /**
     * @param Collection|null $codebook
     * @return null|array
     */
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

    /**
     * @param array $arr
     */
    private function saveCodebookVariables(array $arr)
    {
        if ($arr && is_iterable($arr) && key_exists('variables', $arr) && !empty($arr['variables']) && is_iterable($arr['variables'])) {
            foreach ($arr['variables'] as $variable) {
                if (key_exists("var_db_id", $variable)) {
                    $var = $this->em->getRepository(DatasetVariables::class)->find($variable["var_db_id"]);
                    $var->setName($variable["name"] ?? $var->getName());
                    $var->setLabel($variable["label"] ?? null);
                    $var->setItemText($variable["itemText"] ?? null);
                    $var->setValues($variable["values"] ?? null);
                    $var->setMissings($variable["missings"] ?? null);
                    $var->setMeasure($variable["measure"] ?? null);
                    $this->em->persist($var);
                    $this->em->flush();
                }
            }
        }
    }

}
