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

    public static $rolesDefinition = [
        'user' => 'ROLE_USER',
        'admin' => 'ROLE_ADMIN',
    ];

    public function __construct($uuid, bool $admin = false)
    {
        $this->uuid = $uuid;
        $this->roles = [];

        // Ensure at least one valid role on each user
        $this->roles[] = self::$rolesDefinition['user'];
        // Create an admin if needed
        if ($admin) {
            $this->roles[] = self::$rolesDefinition['admin'];
        }
    }

    public function getRoles()
    {
        // better be sure than sorry
        return array_unique($this->roles);
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

    public function promotion()
    {
        $this->roles[] = self::$rolesDefinition['admin'];
    }

    public function demotion()
    {
        array_diff($this->getRoles(), [self::$rolesDefinition['admin']]);
    }
}
