<?php


namespace App\View\Controller;

use App\Crud\Crudable;
use App\Domain\Model\Codebook\DatasetVariables;
use App\Domain\Model\Filemanagement\AdditionalMaterial;
use App\Domain\Model\Filemanagement\Dataset;
use App\Io\Formats\Csv\CsvImportable;
use App\Io\Formats\Sav\SavImportable;
use App\Questionnaire\Questionnairable;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\View\Controller
 */
#[Route(path: '/filemanagement', name: 'File-')]
#[IsGranted('ROLE_USER')]
class FileManagementController extends AbstractController
{
    public function __construct(private readonly Crudable $crud, private readonly Questionnairable $questionnaire, private readonly CsvImportable $csvImportable, private readonly SavImportable $savImportable, private readonly EntityManagerInterface $em, private readonly LoggerInterface $logger)
    {
    }


    #[Route(path: '/preview/sav/{fileId}', name: 'preview-sav')]
    public function previewSavAction(string $fileId): JsonResponse
    {
        $this->logger->debug("Enter FileManagementController::previewSavAction with [FileId: $fileId]");
        $dataset = $this->em->find(Dataset::class, $fileId);
        $data = null;
        if ($dataset) {
            $data = $this->savImportable->savToArray($dataset);
        }

        return new JsonResponse($data ?? [], null != $data ? Response::HTTP_OK : Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Route(path: '/submit/sav/{fileId}', name: 'submit-sav')]
    public function submitSavAction(string $fileId): JsonResponse
    {
        $this->logger->debug("Enter FileManagementController::previewSavAction with [FileId: $fileId]");
        $dataset = $this->em->find(Dataset::class, $fileId);
        $data = null;
        if ($dataset) {
            $data = $this->savImportable->savToArray($dataset);
        }
        if (isset($dataset) && isset($data) && !empty($data)) {
            if ($data && is_iterable($data) && key_exists('codebook', $data)) {
                foreach ($data['codebook'] as $var) {
                    $matrixHeader[] = $var['name'];
                    $this->em->persist(
                        DatasetVariables::createNew(
                            $dataset,
                            $var['id'],
                            $var['name'],
                            $var['label'],
                            $var['itemText'],
                            $var['values'],
                            $var['missings'],
                        )
                    );
                }
                $this->em->flush();
                if (key_exists('records', $data)) {
                    $this->crud->saveDatasetMatrix($data['records'], $dataset->getId());
                }
            }
        }

        return new JsonResponse($data ?? [], null != $data ? Response::HTTP_OK : Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Route(path: '/preview/csv/{fileId}', name: 'preview-csv')]
    public function previewCsvAction(string $fileId, Request $request): JsonResponse
    {
        $this->logger->debug("Enter FileManagementController::previewCSVAction with [FileId: $fileId]");
        $delimiter = $request->get('dataset-import-delimiter') ?? ",";
        $escape = $request->get('dataset-import-escape') ?? "double";
        $headerRows = filter_var($request->get('dataset-import-header-rows'), FILTER_VALIDATE_INT) ?? 0;
        $file = $this->em->find(Dataset::class, $fileId);
        $data = null;
        if ($file) {
            $data = $this->csvImportable->csvToArray($file->getStorageName(), $delimiter, $escape, $headerRows, 5);
        }

        return new JsonResponse($data, $data ? Response::HTTP_OK : Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Route(path: '/submit/csv/{fileId}', name: 'submit-csv')]
    public function submitCSVAction(string $fileId, Request $request): JsonResponse
    {
        $this->logger->debug("Enter FileManagementController::submitCSVAction with [FileId: $fileId]");
        $delimiter = $request->get('dataset-import-delimiter') ?? ",";
        $escape = $request->get('dataset-import-escape') ?? "double";
        $remove = $request->get('dataset-import-remove') ?? null;
        $headerRows = filter_var($request->get('dataset-import-header-rows'), FILTER_VALIDATE_INT) ?? 0;
        $dataset = $this->em->find(Dataset::class, $fileId);
        $data = null;
        $error = null;
        if ($dataset) {
            if ($remove) {
                $error = $this->crud->deleteDataset($dataset) ? false : "error.import.csv.codebook.delete";
            } else {
                $data = $this->csvImportable->csvToArray($dataset->getStorageName(), $delimiter, $escape, $headerRows);
                if ($data && key_exists('header', $data) && is_iterable($data['header']) && sizeof($data['header']) > 0) {
                    $varId = 1;
                    foreach ($data['header'] as $var) {
                        $this->em->persist(DatasetVariables::createNew($dataset, $varId++, $var));
                    }
                    $this->em->flush();
                } elseif ($data && key_exists('records', $data) && is_iterable($data['records']) && sizeof($data['records']) > 0) {
                    $varId = 1;
                    foreach ($data['records'][0] as $ignored) {
                        $this->em->persist(DatasetVariables::createNew($dataset, $varId, "var_$varId"));
                        $varId++;
                    }
                    $this->em->flush();
                } else {
                    $error = "error.import.csv.codebook.empty";
                }
                if (null == $error && $data && key_exists('records', $data) && is_iterable($data['records']) && sizeof($data['records']) > 0) {
                    $this->crud->saveDatasetMatrix($data['records'], $dataset->getId());
                } else {
                    $error = "error.import.csv.matrix.empty";
                }
            }
        } else {
            $error = "error.import.csv.dataset.empty";
        }
        if (null != $error && !$remove) {
            $this->crud->deleteDataset($dataset);
        }

        return new JsonResponse(
            null != $error ? $error : $data,
            null != $error ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK
        );
    }

    #[Route(path: '/{uuid}/delete/dataset', name: 'delete_dataset')]
    public function deleteDatasetAction(string $uuid): RedirectResponse
    {
        $this->logger->debug("Enter FileManagementController::deleteMaterialAction with [UUID: $uuid]");
        $dataset = $this->em->find(Dataset::class, $uuid);
        $experimentId = $dataset->getExperiment()->getId();
        $this->crud->deleteDataset($dataset);

        return $this->redirectToRoute('Study-datasets', ['uuid' => $experimentId]);
    }


    #[Route(path: '/{uuid}/delete/material', name: 'delete_material')]
    public function deleteMaterialAction(string $uuid): RedirectResponse
    {
        $this->logger->debug("Enter FileManagementController::deleteMaterialAction with [UUID: $uuid]");
        $material = $this->em->find(AdditionalMaterial::class, $uuid);
        $experimentId = $material->getExperiment()->getId();
        $this->crud->deleteMaterial($material);

        return $this->redirectToRoute('Study-materials', ['uuid' => $experimentId]);
    }

    #[Route(path: '/{uuid}/update/description', name: 'update_description', methods: ['POST'])]
    public function updateDescriptionAction(string $uuid, Request $request): JsonResponse
    {
        $this->logger->debug("Enter FileManagementController::updateDescriptionAction with [UUID: $uuid]");
        $entity = $this->em->find(AdditionalMaterial::class, $uuid);
        $success = false;
        if ($entity == null) {
            $entity = $this->em->find(Dataset::class, $uuid);
        }
        if ($entity) {
            $description = $request->getContent();
            $entity->setDescription($description);
            $this->em->persist($entity);
            $this->em->flush();
            $success = true;
        }

        return new JsonResponse(['success' => $success], $success ? Response::HTTP_OK : Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    #[Route(path: '/{uuid}/details', name: 'details')]
    public function materialDetailsAction(string $uuid, Request $request): Response
    {
        $this->logger->debug("Enter FileManagementController::materialDetailsAction with [UUID: $uuid]");
        $entityAtChange = $this->em->find(AdditionalMaterial::class, $uuid);
        $experiment = $entityAtChange->getExperiment();
        $form = $this->questionnaire->askAndHandle(
            $entityAtChange,
            'save',
            $request
        );
        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->em->persist($entityAtChange);
            $this->em->flush();
        }

        return $this->render(
            'Pages/FileManagement/materialDetails.html.twig',
            [
                'form' => $form->createView(),
                'file' => $entityAtChange,
                'experiment' => $experiment,
            ]
        );
    }
}
