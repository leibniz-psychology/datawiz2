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
    use AuthorizableDefault;

    /**
     * @ORM\Column(type="json")
     */
    private $roles;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="uuid", nullable=true)
     */
    private $keycloakUuid;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getKeycloakUuid()
    {
        return $this->keycloakUuid;
    }

    /**
     * @param mixed $keycloakUuid
     */
    public function setKeycloakUuid($keycloakUuid): void
    {
        $this->keycloakUuid = $keycloakUuid;
    }

    public function __construct(string $displayName, bool $admin = false)
    {
        $this->email = $displayName;
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
        return $this->email;
    }

    public function eraseCredentials()
    {
        return null;
    }
}
