<?php

namespace App\Crud;

use App\Domain\Model\Filemanagement\AdditionalMaterial;
use App\Domain\Model\Filemanagement\Dataset;
use App\Domain\Model\Study\Experiment;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\UnableToReadFile;

class CrudService implements Crudable
{
    public function __construct(private readonly Filesystem $filesystem, private readonly EntityManagerInterface $em)
    {
    }

    /**
     * Wrapper for find from EntityManager.
     *
     * @param mixed $id
     */
    public function readById(string $type, $id)
    {
        return $this->em
            ->getRepository($type)
            ->find($id);
    }

    /**
     * Wrapper to get all entities for given type.
     */
    public function readForAll(string $type): array
    {
        return $this->em
            ->getRepository($type)
            ->findAll();
    }

    /**
     * Wrapper to call findBy from the repository of the given type.
     *
     * @param null|mixed $limit
     * @param null|mixed $offset
     */
    public function readByCriteria(string $type, array $criteria, ?array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->em
            ->getRepository($type)
            ->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Wrapper to persist and flush an entity in one call.
     *
     * @param mixed $entity
     */
    public function update(&$entity): void
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * Wrapper to delete and flush an entity in one call.
     *
     * @param mixed $entity
     */
    public function delete($entity): void
    {
        $this->em->remove($entity);
        $this->em->flush();
    }

    /**
     * Start a transaction and do with the EntityManager anything you need
     * After the callback a flush will end the transaction.
     */
    public function doTransaction(callable $callback)
    {
        $this->em->beginTransaction();
        $callback($this->em);
        $this->em->flush();
    }

    public function deleteMaterial(AdditionalMaterial $material): bool
    {
        try {
            if ($this->filesystem->has($material->getStorageName())) {
                $this->filesystem->delete($material->getStorageName());
            }
            $this->em->remove($material);
            $this->em->flush();
            $success = true;
        } catch (UnableToReadFile) {
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
            if ($this->filesystem->has('matrix/'.$dataset->getId().'.csv')) {
                $this->filesystem->delete('matrix/'.$dataset->getId().'.csv');
            }
            if ($dataset->getCodebook() != null) {
                foreach ($dataset->getCodebook() as $var) {
                    $this->em->remove($var);
                }
            }
            $this->em->remove($dataset);
            $this->em->flush();
            $success = true;
        } catch (UnableToReadFile) {
            $success = false;
        }

        return $success;
    }

    public function saveDatasetMatrix(array $matrix, string $datasetId): bool
    {
        try {
            $tmp = new \SplTempFileObject();
            foreach ($matrix as $record) {
                $tmp->fputcsv($record);
            }
            $reader = Reader::createFromFileObject($tmp);
            $this->filesystem->write("matrix/{$datasetId}.csv", $reader->toString());
            $success = true;
        } catch (FilesystemException|Exception) {
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
                if (!$this->deleteMaterial($mat)) {
                    $success = false;
                    break;
                }
            }
        }
        if ($creators = $experiment->getBasicInformationMetaDataGroup()->getCreators()) {
            foreach ($creators as $creator) {
                $this->em->remove($creator);
            }
        }
        if ($success) {
            $this->em->remove($experiment);
            $this->em->flush();
        }

        return $success;
    }
}
