<?php

namespace App\Domain\Model;

use App\Domain\Access\DataWizUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=DataWizUserRepository::class)
 */
class DataWizUser implements UserInterface
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

    public function __construct($uuid)
    {
        $this->uuid = $uuid;
        $this->roles = [];
    }

    public function getRoles()
    {
        // Ensure at least one valid role on each user
        if (!in_array('ROLE_USER', $this->roles, true)) {
            $this->roles[] = 'ROLE_USER';
        }

        // better be sure than sorry
        return array_unique($this->roles);
    }

    public function getPassword()
    {
        // should never be called
    }

    public function getSalt()
    {
        // should never be called
    }

    public function getUsername()
    {
        return $this->uuid;
    }

    public function eraseCredentials()
    {
        // should never be called
    }
}
