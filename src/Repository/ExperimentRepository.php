<?php

namespace App\Repository;

use App\Entity\Study\Experiment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method null|Experiment find($id, $lockMode = null, $lockVersion = null)
 * @method null|Experiment findOneBy(array $criteria, array $orderBy = null)
 * @method Experiment[]    findAll()
 * @method Experiment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExperimentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Experiment::class);
    }

    public function findByBasicMetadata(array $orderBy = null, $limit = null, $offset = null)
    {
        $qb = $this->createQueryBuilder('e');
        if (is_iterable($orderBy) && sizeof($orderBy) > 1) {
            switch ($orderBy[0]) {
                case 'shortName':
                    $qb->join('e.settingsMetaDataGroup', 'es')
                        ->orderBy('es.'.$orderBy[0], $orderBy[1]);
                    break;
                case 'title':
                    $qb->join('e.basicInformationMetaDataGroup', 'eb')
                        ->orderBy('eb.'.$orderBy[0], $orderBy[1]);
                    break;
            }
        }

        return $qb->setMaxResults($limit)->setFirstResult($offset)
            ->getQuery()
            ->execute();
    }
}
