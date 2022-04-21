<?php

namespace App\Domain\Model\Administration;

use App\Domain\Access\Administration\DataWizUserRepository;
use App\Domain\Definition\UserRoles;
use App\Security\Authorization\Authorizable;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=DataWizUserRepository::class)
 * @ORM\Table(name="user")
 */
class DataWizUser implements UserInterface
{
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

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $dateRegistered;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $lastLogin;


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

    /**
     * @return array
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = UserRoles::USER;

        return array_unique($roles);
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }


    public function getPassword()
    {
        return null;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername(): ?string
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

    /**
     * @return DateTime
     */
    public function getDateRegistered(): DateTime
    {
        return $this->dateRegistered;
    }

    /**
     * @param DateTime $dateRegistered
     */
    public function setDateRegistered(DateTime $dateRegistered): void
    {
        $this->dateRegistered = $dateRegistered;
    }

    /**
     * @return DateTime
     */
    public function getLastLogin(): DateTime
    {
        return $this->lastLogin;
    }

    /**
     * @param DateTime $lastLogin
     */
    public function setLastLogin(DateTime $lastLogin): void
    {
        $this->lastLogin = $lastLogin;
    }


}
