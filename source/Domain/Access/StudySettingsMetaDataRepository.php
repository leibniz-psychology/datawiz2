<?php

namespace App\Domain\Access;

use App\Domain\Model\StudySettingsMetaDataGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class StudySettingsMetaDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudySettingsMetaDataGroup::class);
    }
}
