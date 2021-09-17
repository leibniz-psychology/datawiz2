<?php

namespace App\Crud;

use App\Domain\Model\Filemanagement\AdditionalMaterial;
use App\Domain\Model\Filemanagement\Dataset;
use App\Domain\Model\Study\Experiment;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\Filesystem;

class CrudService implements Crudable
{
    private Filesystem $filesystem;
    private EntityManagerInterface $entityManager;

    /**
     * @param Filesystem $filesystem
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(Filesystem $filesystem, EntityManagerInterface $entityManager)
    {
        $this->filesystem = $filesystem;
        $this->entityManager = $entityManager;
    }


    /**
     * Wrapper for find from EntityManager.
     */
    public function readById(string $type, $id)
    {
        return $this->entityManager
            ->getRepository($type)
            ->find($id);
    }

    /**
     * Wrapper to get all entities for given type.
     */
    public function readForAll(string $type): array
    {
        return $this->entityManager
            ->getRepository($type)
            ->findAll();
    }

    /**
     * Wrapper to call findBy from the repository of the given type.
     */
    public function readByCriteria(string $type, array $criteria, ?array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->entityManager
            ->getRepository($type)
            ->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Wrapper to persist and flush an entity in one call.
     */
    public function update(&$entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    /**
     * Wrapper to delete and flush an entity in one call.
     */
    public function delete($entity): void
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    /**
     * Start a transaction and do with the EntityManager anything you need
     * After the callback a flush will end the transaction.
     */
    public function doTransaction(callable $callback)
    {
        $this->entityManager->beginTransaction();
        $callback($this->entityManager);
        $this->entityManager->flush();
    }

    public function deleteMaterial(AdditionalMaterial $material): bool
    {
        try {
            if ($this->filesystem->has($material->getStorageName())) {
                $this->filesystem->delete($material->getStorageName());
            }
            $this->entityManager->remove($material);
            $this->entityManager->flush();
            $success = true;
        } catch (FileNotFoundException $e) {
            $success = false;
        }

        return $success;
    }


    public function deleteDataset(Dataset $dataset): bool
    {
        try {
            if ($this->filesystem->has($dataset->getStorageName())) {
                $this->filesystem->delete($dataset->getStorageName());
            }
            if ($this->filesystem->has("matrix/".$dataset->getId().".json")) {
                $this->filesystem->delete("matrix/".$dataset->getId().".json");
            }
            if ($dataset->getCodebook() != null) {
                foreach ($dataset->getCodebook() as $var) {
                    $this->entityManager->remove($var);
                }
            }
            $this->entityManager->remove($dataset);
            $this->entityManager->flush();
            $success = true;
        } catch (FileNotFoundException $e) {
            $success = false;
        }

        return $success;
    }

    public function saveDatasetMatrix(array $matrix, string $datasetId): bool
    {
        try {
            if ($this->filesystem->has("matrix/$datasetId.json")) {
                $this->filesystem->update("matrix/$datasetId.json", json_encode($matrix));
            } else {
                $this->filesystem->write("matrix/$datasetId.json", json_encode($matrix));
            }
            $success = true;
        } catch (FileExistsException | FileNotFoundException $e) {
            $success = false;
        }

        return $success;
    }

    public function deleteStudy(Experiment $experiment): bool
    {
        $success = true;
        if ($datasets = $experiment->getOriginalDatasets()) {
            foreach ($datasets as $dataset) {
                if (!$this->deleteDataset($dataset)) {
                    $success = false;
                    break;
                }
            }
        }
        if ($material = $experiment->getAdditionalMaterials()) {
            foreach ($material as $mat) {
                if (!$this->deleteDataset($mat)) {
                    $success = false;
                    break;
                }
            }
        }
        if ($success) {
            $this->entityManager->remove($experiment);
            $this->entityManager->flush();
        }

        return $success;
    }
}
