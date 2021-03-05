<?php

namespace App\Domain\Model\Administration;

use App\Domain\Access\Administration\DataWizUserRepository;
use App\Security\Authorization\Authorizable;
use App\Security\Authorization\AuthorizableDefault;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=DataWizUserRepository::class)
 */
class DataWizUser extends UuidEntity implements UserInterface, Authorizable
{
    /**
     * @ORM\Column(type="json")
     */
    private $roles;

    /**
     * @ORM\Column(type="string")
     */
    private $displayName;

    use AuthorizableDefault;

    public function __construct(string $displayName, bool $admin = false)
    {
        $this->displayName = $displayName;
        // use the trait logic to create a valid role array
        $this->initializeRoles($admin);
    }

    public function getPassword()
    {
        return null;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->displayName;
    }

    public function eraseCredentials()
    {
        return null;
    }
}
