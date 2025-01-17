<?php

namespace App\Entity\Administration;

use App\Entity\Constant\UserRoles;
use App\Repository\DataWizUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[ORM\Table(name: 'user')]
#[ORM\Entity(repositoryClass: DataWizUserRepository::class)]
class DataWizUser implements UserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private Uuid $id;

    #[ORM\Column(type: 'simple_array')]
    private array $roles;

    #[ORM\Column(nullable: true)]
    private ?string $email = null;

    #[ORM\Column(nullable: true)]
    private ?string $firstname = null;

    #[ORM\Column(nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column]
    private ?\DateTime $dateRegistered = null;

    #[ORM\Column]
    private ?\DateTime $lastLogin = null;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = UserRoles::USER;

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function eraseCredentials(): null
    {
        return null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getUserIdentifier(): string
    {
        return $this->getId();
    }

    public function getDateRegistered(): \DateTime
    {
        return $this->dateRegistered;
    }

    public function setDateRegistered(\DateTime $dateRegistered): void
    {
        $this->dateRegistered = $dateRegistered;
    }

    public function getLastLogin(): \DateTime
    {
        return $this->lastLogin;
    }

    public function setLastLogin(\DateTime $lastLogin): void
    {
        $this->lastLogin = $lastLogin;
    }
}
