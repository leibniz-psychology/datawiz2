<?php

namespace App\Controller;

use App\Entity\Codebook\DatasetVariables;
use App\Entity\FileManagement\AdditionalMaterial;
use App\Entity\FileManagement\Dataset;
use App\Service\Crud\Crudable;
use App\Service\Io\Formats\CsvImportable;
use App\Service\Io\Formats\SavImportable;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/filemanagement', name: 'File-')]
#[IsGranted('ROLE_USER')]
class FileManagementController extends AbstractController
{
    public function __construct(
        private readonly Crudable $crud,
        private readonly CsvImportable $csvImportable,
        private readonly SavImportable $savImportable,
        private readonly EntityManagerInterface $em,
        private readonly LoggerInterface $logger
    ) {
    }

    #[Route(path: '/preview/sav/{fileId}', name: 'preview-sav', methods: ['POST'])]
    public function previewSavAction(string $fileId): JsonResponse
    {
        $this->logger->debug("Enter FileManagementController::previewSavAction with [FileId: {$fileId}]");
        $dataset = $this->em->find(Dataset::class, $fileId);
        $data = null;
        if ($dataset) {
            $data = $this->savImportable->savToArray($dataset);
        }

        return new JsonResponse($data ?? [], $data != null ? Response::HTTP_OK : Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Route(path: '/submit/sav/{fileId}', name: 'submit-sav', methods: ['POST'])]
    public function submitSavAction(string $fileId): JsonResponse
    {
        $this->logger->debug("Enter FileManagementController::previewSavAction with [FileId: {$fileId}]");
        $dataset = $this->em->find(Dataset::class, $fileId);
        $data = null;
        if ($dataset) {
            $data = $this->savImportable->savToArray($dataset);
        }
        if (isset($dataset, $data) && !empty($data)) {
            if (is_iterable($data) && key_exists('codebook', $data)) {
                foreach ($data['codebook'] as $var) {
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

        return new JsonResponse($data ?? [], $data != null ? Response::HTTP_OK : Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Route(path: '/preview/csv/{fileId}', name: 'preview-csv', methods: ['POST'])]
    public function previewCsvAction(string $fileId, Request $request): JsonResponse
    {
        $this->logger->debug("Enter FileManagementController::previewCSVAction with [FileId: {$fileId}]");
        $delimiter = $request->get('dataset-import-delimiter') ?? ',';
        $escape = $request->get('dataset-import-escape') ?? 'double';
        $headerRows = filter_var($request->get('dataset-import-header-rows'), FILTER_VALIDATE_INT) ?? 0;
        $file = $this->em->find(Dataset::class, $fileId);
        $data = null;
        if ($file) {
            $data = $this->csvImportable->csvToArray($file->getStorageName(), $delimiter, $escape, $headerRows, 5);
        }

        return new JsonResponse($data, $data ? Response::HTTP_OK : Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Route(path: '/submit/csv/{fileId}', name: 'submit-csv', methods: ['POST'])]
    public function submitCSVAction(string $fileId, Request $request): JsonResponse
    {
        $this->logger->debug("Enter FileManagementController::submitCSVAction with [FileId: {$fileId}]");
        $delimiter = $request->get('dataset-import-delimiter') ?? ',';
        $escape = $request->get('dataset-import-escape') ?? 'double';
        $remove = $request->get('dataset-import-remove') ?? null;
        $headerRows = filter_var($request->get('dataset-import-header-rows'), FILTER_VALIDATE_INT) ?? 0;
        $dataset = $this->em->find(Dataset::class, $fileId);
        $data = null;
        $error = null;
        if ($dataset) {
            if ($remove) {
                $error = $this->crud->deleteDataset($dataset) ? false : 'error.import.csv.codebook.delete';
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
                        $this->em->persist(DatasetVariables::createNew($dataset, $varId, "var_{$varId}"));
                        ++$varId;
                    }
                    $this->em->flush();
                } else {
                    $error = 'error.import.csv.codebook.empty';
                }
                if ($error == null && $data && key_exists('records', $data) && is_iterable($data['records']) && sizeof($data['records']) > 0) {
                    $this->crud->saveDatasetMatrix($data['records'], $dataset->getId());
                } else {
                    $error = 'error.import.csv.matrix.empty';
                }
            }
        } else {
            $error = 'error.import.csv.dataset.empty';
        }
        if ($error != null && !$remove) {
            $this->crud->deleteDataset($dataset);
        }

        return new JsonResponse(
            $error != null ? $error : $data,
            $error != null ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK
        );
    }

    #[Route(path: '/{uuid}/delete/dataset', name: 'delete_dataset', methods: ['POST'])]
    public function deleteDatasetAction(string $uuid): RedirectResponse
    {
        $this->logger->debug("Enter FileManagementController::deleteMaterialAction with [UUID: {$uuid}]");
        $dataset = $this->em->find(Dataset::class, $uuid);
        $experimentId = $dataset->getExperiment()->getId();
        $this->crud->deleteDataset($dataset);

        return $this->redirectToRoute('Study-datasets', ['uuid' => $experimentId]);
    }

    #[Route(path: '/{uuid}/delete/material', name: 'delete_material', methods: ['POST'])]
    public function deleteMaterialAction(string $uuid): RedirectResponse
    {
        $this->logger->debug("Enter FileManagementController::deleteMaterialAction with [UUID: {$uuid}]");
        $material = $this->em->find(AdditionalMaterial::class, $uuid);
        $experimentId = $material->getExperiment()->getId();
        $this->crud->deleteMaterial($material);

        return $this->redirectToRoute('Study-materials', ['uuid' => $experimentId]);
    }

    #[Route(path: '/{uuid}/update/description', name: 'update_description', methods: ['POST'])]
    public function updateDescriptionAction(string $uuid, Request $request): JsonResponse
    {
        $this->logger->debug("Enter FileManagementController::updateDescriptionAction with [UUID: {$uuid}]");
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
}
