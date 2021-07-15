<?php

namespace App\Domain\Access\Administration;

use App\Domain\Model\Administration\DataWizUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * @method DataWizUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataWizUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataWizUser[]    findAll()
 * @method DataWizUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataWizUserRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataWizUser::class);
    }

    public function loadUserByIdentifier(string $uuidOrEmail): ?DataWizUser
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->createQuery(
            'SELECT u
                FROM App\Domain\Model\Administration\DataWizUser u
                WHERE u.keycloakUuid = :query
                OR u.email = :query'
        )
            ->setParameter('query', $uuidOrEmail)
            ->getOneOrNullResult();
    }

    public function loadUserByUsername(string $username)
    {
        return $this->loadUserByIdentifier($username);
    }
}
