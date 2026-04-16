<?php

namespace App\Repository;

use App\Entity\Study\BasicInformationMetaDataGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BasicInformationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BasicInformationMetaDataGroup::class);
    }

    public function save(BasicInformationMetaDataGroup $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }
}
