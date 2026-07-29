<?php

namespace App\Repository\DataManagementPlan;

use App\Entity\DataManagementPlan\DmpDataSharing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DmpDataSharingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DmpDataSharing::class);
    }

    public function save(DmpDataSharing $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }
}
