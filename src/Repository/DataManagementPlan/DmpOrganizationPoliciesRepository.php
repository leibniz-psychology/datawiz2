<?php

namespace App\Repository\DataManagementPlan;

use App\Entity\DataManagementPlan\DmpOrganizationPolicies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DmpOrganizationPoliciesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DmpOrganizationPolicies::class);
    }

    public function save(DmpOrganizationPolicies $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }
}
