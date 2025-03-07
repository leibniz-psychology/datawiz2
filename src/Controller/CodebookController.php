<?php

namespace App\Controller;

use App\Entity\Codebook\DatasetVariables;
use App\Entity\FileManagement\Dataset;
use App\Entity\Study\MeasureMetaDataGroup;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use League\Csv\UnableToProcessCsv;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/codebook', name: 'codebook_')]
#[IsGranted('ROLE_USER')]
class CodebookController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected LoggerInterface $logger,
        private readonly FilesystemOperator $matrixFilesystem,
    ) {}

    #[Route(path: '/{id}', name: 'index', methods: ['GET'])]
    public function codebookIndex(Dataset $dataset): Response
    {
        return $this->render('pages/codebook/index.html.twig', [
            'codebook' => $dataset,
        ]);
    }

    #[Route(path: '/{id}/data', name: 'dataupdate', methods: ['GET', 'POST'])]
    public function performUpdate(Dataset $dataset, Request $request): JsonResponse
    {
        $this->logger->debug("Enter CodebookController::performUpdateAction with [UUID: {$dataset->getId()}]");
        if ($request->isMethod('POST')) {
            $postedData = $request->getPayload()->all();
            $this->saveCodebookVariables($postedData);
        }
        $jsonCodebook = $this->codebookCollectionToJsonArray($dataset->getCodebook());

        return new JsonResponse($jsonCodebook, $jsonCodebook != null ? Response::HTTP_OK : Response::HTTP_NO_CONTENT);
    }

    #[Route(path: '/{id}/measures', name: 'measures', methods: ['GET'])]
    public function createViewMeasures(Dataset $dataset): JsonResponse
    {
        $this->logger->debug("Enter CodebookController::createViewMeasuresAction with [UUID: {$dataset->getId()}]");
        $viewMeasures = [];
        $measures = $this->em->getRepository(MeasureMetaDataGroup::class)->findOneBy(['experiment' => $dataset->getExperiment()]);
        if ($measures && $measures->getMeasures()) {
            foreach ($measures->getMeasures() as $measure) {
                if ($measure && $measure != '') {
                    $viewMeasures['measures'][] = $measure;
                }
            }
        }

        return new JsonResponse($viewMeasures, key_exists('measures', $viewMeasures) ? Response::HTTP_OK : Response::HTTP_NO_CONTENT);
    }

    #[Route(path: '/{id}/matrix', name: 'matrix', methods: ['GET'])]
    public function datasetMatrix(Dataset $dataset, #[MapQueryParameter()] int $size = 0, #[MapQueryParameter] int $page = 1): JsonResponse
    {
        $this->logger->debug("Enter CodebookController::datasetMatrixAction with [UUID: {$dataset->getId()}]");
        $response = null;

        foreach ($dataset->getCodebook() as $var) {
            $response['header'][] = $var->getName();
        }

        try {
            if (!$this->matrixFilesystem->has($dataset->getId().'.csv')) {
                return new JsonResponse($response, Response::HTTP_OK);
            }

            $file = Reader::createFromString($this->matrixFilesystem->read($dataset->getId().'.csv'));
            if ($file->count() === 0) {
                $response['error'] = 'error.dataset.matrix.empty';
                return new JsonResponse($response, Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if ($size == 0) {
                $response['content'] = $file;
                $response['pagination']['max_items'] = $file->count();
                $response['pagination']['items'] = $file->count();
                $response['pagination']['current_page'] = 1;
                $response['pagination']['max_pages'] = 1;
            } else {
                $min = $page != 0 ? ($page - 1) * $size : 0;
                $max = $min + $size;
                for ($count = $min; $count < $max; ++$count) {
                    $response['content'][] = $file->fetchOne($count);
                }
                $response['pagination']['max_items'] = $file->count();
                $response['pagination']['items'] = $size;
                $response['pagination']['current_page'] = $page;
                $response['pagination']['max_pages'] = ceil($file->count() / $size);
            }
        } catch (FilesystemException $e) {
            $this->logger->critical("FileSystemException in CodebookController::createViewMeasuresAction [UUID: {$dataset->getId()}] Exception: ".$e->getMessage());
            $response['error'] = 'error.dataset.matrix.notFound';
            return new JsonResponse($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (UnableToProcessCsv $e) {
            $this->logger->critical("UnableToProcessCsv in CodebookController::createViewMeasuresAction [UUID: {$dataset->getId()}] Exception: ".$e->getMessage());
            $response['error'] = 'error.dataset.matrix.unprocessable';
            return new JsonResponse($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return new JsonResponse($response, Response::HTTP_OK);
    }

    private function codebookCollectionToJsonArray(?Collection $codebook): ?array
    {
        $jsonCodebook = null;
        if ($codebook) {
            $jsonCodebook = [];
            foreach ($codebook as $var) {
                $jsonCodebook['variables'][] = [
                    'id' => $var->getVarId(),
                    'name' => $var->getName() ?? '',
                    'label' => $var->getLabel() ?? '',
                    'itemText' => $var->getItemText() ?? '',
                    'values' => $var->getValues() ?? [
                        [
                            'name' => '',
                            'label' => '',
                        ],
                    ],
                    'missings' => $var->getMissings() ?? [
                        [
                            'name' => '',
                            'label' => '',
                        ],
                    ],
                    'measure' => $var->getMeasure() ?? '',
                    'var_db_id' => $var->getId(),
                ];
            }
        }

        return $jsonCodebook;
    }

    private function saveCodebookVariables(array $arr)
    {
        if ($arr && key_exists('variables', $arr) && !empty($arr['variables']) && is_iterable($arr['variables'])) {
            foreach ($arr['variables'] as $variable) {
                if (key_exists('var_db_id', $variable)) {
                    $values = $variable['values'] ? $this->setMissingArrayFields(array_values(array_filter($variable['values']))) : null;
                    $missings = $variable['missings'] ? $this->setMissingArrayFields(array_values(array_filter($variable['missings']))) : null;
                    $var = $this->em->getRepository(DatasetVariables::class)->find($variable['var_db_id']);
                    $var->setName($variable['name'] ?? $var->getName());
                    $var->setLabel($variable['label'] ?? null);
                    $var->setItemText($variable['itemText'] ?? null);
                    $var->setValues($values != null ? $values : null);
                    $var->setMissings($missings != null ? $missings : null);
                    $var->setMeasure($variable['measure'] ?? null);
                    $this->em->persist($var);
                    $this->em->flush();
                }
            }
        }
    }

    private function setMissingArrayFields(?array $arr): ?array
    {
        if ($arr != null) {
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
