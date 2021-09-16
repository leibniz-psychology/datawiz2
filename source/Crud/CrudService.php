<?php

namespace App\Crud;

use Doctrine\ORM\EntityManagerInterface;

class CrudService implements Crudable
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
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
    public function readByCriteria(string $type, array $criteria,
                                   ?array $orderBy = null, $limit = null,
                                   $offset = null)
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
}
