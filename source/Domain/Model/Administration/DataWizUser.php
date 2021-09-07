<?php

namespace App\Domain\Model\Administration;

use App\Domain\Access\Administration\DataWizUserRepository;
use App\Security\Authorization\Authorizable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=DataWizUserRepository::class)
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
    private string $email;

    /**
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Administration\DataWizSettings", mappedBy="owner", cascade={"persist"})
     */
    private DataWizSettings $datawizSettings;

    public function __construct(string $displayName, bool $admin = false)
    {
        $this->email = $displayName;
        $this->datawizSettings = new DataWizSettings();
        // use the trait logic to create a valid role array
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getUserIdentifier(): string
    {
        return $this->getId();
    }

    public function getDatawizSettings(): DataWizSettings
    {
        return $this->datawizSettings;
    }

    public function setDatawizSettings($datawizSettings): void
    {
        $this->datawizSettings = $datawizSettings;
    }
}
