<?php

namespace App\Repository\DataManagementPlan;

use App\Entity\DataManagementPlan\DmpAdministrativeData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DmpAdministrativeDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DmpAdministrativeData::class);
    }

    public function save(DmpAdministrativeData $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }
}
