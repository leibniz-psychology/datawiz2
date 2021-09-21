<?php

namespace App\Domain\Model\Administration;

use App\Domain\Access\Administration\DataWizUserRepository;
use App\Security\Authorization\Authorizable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=DataWizUserRepository::class)
 * @ORM\Table(name="user")
 */
class DataWizUser implements UserInterface
{
    use Authorizable;

    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     */
    private UUid $id;

    /**
     * @ORM\Column(type="simple_array")
     */
    private array $roles;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $email = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $firstname = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $lastname = null;


    public function __construct(bool $admin = false)
    {
        $this->initializeRoles($admin);
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @param Uuid $id
     */
    public function setId(Uuid $id): void
    {
        $this->id = $id;
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

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string|null $firstname
     */
    public function setFirstname(?string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string|null $lastname
     */
    public function setLastname(?string $lastname): void
    {
        $this->lastname = $lastname;
    }


    public function getUserIdentifier(): ?string
    {
        return $this->getId();
    }
}
