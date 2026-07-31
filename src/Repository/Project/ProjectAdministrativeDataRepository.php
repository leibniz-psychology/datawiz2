<?php

declare(strict_types=1);

namespace App\Repository\Project;

use App\Entity\Project\ProjectAdministrativeData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProjectAdministrativeDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectAdministrativeData::class);
    }

    public function save(ProjectAdministrativeData $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }
}
