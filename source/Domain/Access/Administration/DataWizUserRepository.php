<?php

namespace App\Domain\Access\Administration;

use App\Domain\Model\Administration\DataWizUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DataWizUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataWizUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataWizUser[]    findAll()
 * @method DataWizUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataWizUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataWizUser::class);
    }

    // /**
    //  * @return Label[] Returns an array of Label objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Label
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
