<?php

namespace App\Repository\DataManagementPlan;

use App\Entity\DataManagementPlan\DmpEthicalLegal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DmpEthicalLegalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DmpEthicalLegal::class);
    }

    public function save(DmpEthicalLegal $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }
}
