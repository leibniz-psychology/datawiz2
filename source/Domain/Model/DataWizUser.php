<?php

namespace App\Domain\Model;

use App\Domain\Access\DataWizUserRepository;
use App\Security\Authorization\Authorizable;
use App\Security\Authorization\AuthorizableDefault;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=DataWizUserRepository::class)
 */
class DataWizUser implements UserInterface, Authorizable
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string")
     */
    private $uuid;

    /**
     * @ORM\Column(type="json")
     */
    private $roles;

    use AuthorizableDefault;

    public function __construct($uuid, bool $admin = false)
    {
        $this->uuid = $uuid;
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
        return $this->uuid;
    }

    public function eraseCredentials()
    {
        return null;
    }
}
