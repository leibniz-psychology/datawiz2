<?php

namespace App\Repository;

use App\Entity\Administration\DataWizUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * @method null|DataWizUser find($id, $lockMode = null, $lockVersion = null)
 * @method null|DataWizUser findOneBy(array $criteria, array $orderBy = null)
 * @method DataWizUser[]    findAll()
 * @method DataWizUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataWizUserRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataWizUser::class);
    }

    public function loadUserByIdentifier(string $identifier): ?DataWizUser
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->createQuery(
            'SELECT u
                FROM App\Entity\Administration\DataWizUser u
                WHERE u.id = :query
                OR u.email = :query'
        )
            ->setParameter('query', $identifier)
            ->getOneOrNullResult();
    }

    public function loadUserByUsername(string $username): ?DataWizUser
    {
        return $this->loadUserByIdentifier($username);
    }
}
