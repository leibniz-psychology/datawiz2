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
        throw new \Exception('DataWiz uses a SSO and getPassword() should therefore never be called');
    }

    public function getSalt()
    {
        throw new \Exception('DataWiz uses a SSO and getSalt() should therefore never be called');
    }

    public function getUsername()
    {
        return $this->uuid;
    }

    public function eraseCredentials()
    {
        throw new \Exception('DataWiz uses a SSO and eraseCredentials() should therefore never be called');
    }
}
