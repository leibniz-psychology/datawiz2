<?php

namespace App\Repository\DataManagementPlan;

use App\Entity\DataManagementPlan\DmpStorageInfrastructure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DmpStorageInfrastructureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DmpStorageInfrastructure::class);
    }

    public function save(DmpStorageInfrastructure $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }
}
