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
use Symfony\Component\Routing\Attribute\Route;
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
    ) {}

    #[Route(path: '/preview/sav/{id}', name: 'preview-sav', methods: ['POST'])]
    public function previewSav(Dataset $dataset): JsonResponse
    {
        $this->logger->debug("Enter FileManagementController::previewSavAction with [FileId: {$dataset->getId()}]");
        $data = $this->savImportable->savToArray($dataset);

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route(path: '/submit/sav/{id}', name: 'submit-sav', methods: ['POST'])]
    public function submitSav(Dataset $dataset): JsonResponse
    {
        $this->logger->debug("Enter FileManagementController::previewSavAction with [FileId: {$dataset->getId()}]");

        $data = $this->savImportable->savToArray($dataset);

        if (key_exists('codebook', $data)) {
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

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route(path: '/preview/csv/{id}', name: 'preview-csv', methods: ['POST'])]
    public function previewCsv(Dataset $dataset, Request $request): JsonResponse
    {
        $this->logger->debug("Enter FileManagementController::previewCSVAction with [FileId: {$dataset->getId()}]");
        $delimiter = $request->get('dataset-import-delimiter') ?? ',';
        $escape = $request->get('dataset-import-escape') ?? 'double';
        $headerRows = filter_var($request->get('dataset-import-header-rows'), FILTER_VALIDATE_INT);
        if (!$headerRows) {
            $headerRows = 0;
        }

        $data = $this->csvImportable->csvToArray($dataset->getStorageName(), $delimiter, $escape, $headerRows, 5);
        if ($data === null) {
            return new JsonResponse(null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route(path: '/submit/csv/{id}', name: 'submit-csv', methods: ['POST'])]
    public function submitCSV(Dataset $dataset, Request $request): JsonResponse
    {
        $this->logger->debug("Enter FileManagementController::submitCSVAction with [FileId: {$dataset->getId()}]");
        $delimiter = $request->get('dataset-import-delimiter') ?? ',';
        $escape = $request->get('dataset-import-escape') ?? 'double';
        $remove = $request->get('dataset-import-remove') ?? null;
        $headerRows = filter_var($request->get('dataset-import-header-rows'), FILTER_VALIDATE_INT);
        if (!$headerRows) {
            $headerRows = 0;
        }
        $data = null;
        $error = null;
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

        if ($error != null && !$remove) {
            $this->crud->deleteDataset($dataset);
        }

        return new JsonResponse(
            $error != null ? $error : $data,
            $error != null ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK
        );
    }

    #[Route(path: '/{id}/delete/dataset', name: 'delete_dataset', methods: ['POST'])]
    public function deleteDataset(Dataset $dataset): RedirectResponse
    {
        $this->logger->debug("Enter FileManagementController::deleteMaterialAction with [UUID: {$dataset->getId()}]");
        $experimentId = $dataset->getExperiment()->getId();
        $this->crud->deleteDataset($dataset);

        return $this->redirectToRoute('Study-datasets', ['id' => $experimentId]);
    }

    #[Route(path: '/{id}/delete/material', name: 'delete_material', methods: ['POST'])]
    public function deleteMaterial(AdditionalMaterial $material): RedirectResponse
    {
        $this->logger->debug("Enter FileManagementController::deleteMaterialAction with [UUID: {$material->getId()}]");
        $experimentId = $material->getExperiment()->getId();
        $this->crud->deleteMaterial($material);

        return $this->redirectToRoute('Study-materials', ['id' => $experimentId]);
    }

    #[Route(path: '/{id}/update/description', name: 'update_description', methods: ['POST'])]
    public function updateDescription(string $id, Request $request): JsonResponse
    {
        $this->logger->debug("Enter FileManagementController::updateDescriptionAction with [UUID: {$id}]");
        $entity = $this->em->find(AdditionalMaterial::class, $id);
        $success = false;
        if ($entity == null) {
            $entity = $this->em->find(Dataset::class, $id);
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
