<?php

namespace App\Security\Authorization;

trait Authorizable
{
    /**
     * @var string[]
     */
    private $roles;

    /**
     * @var string[]
     *               Define all possible roles
     */
    public static $rolesDefinition = [
        'user' => 'ROLE_USER',
        'admin' => 'ROLE_ADMIN',
    ];

    /**
     * @param bool $admin
     *                    Helper function to initialize a new user with valid roles array
     */
    private function initializeRoles(bool $admin)
    {
        // Ensure at least one valid role on each user
        $this->roles[] = self::$rolesDefinition['user'];
        // Create an admin if needed
        if ($admin) {
            $this->roles[] = self::$rolesDefinition['admin'];
        }
    }

    /**
     * @return string[]
     *                  Getter for the roles property
     */
    public function getRoles(): array
    {
        // better be sure than sorry
        return array_unique($this->roles);
    }

    /**
     * @return void
     * Promote user to admin
     */
    public function promotion(): void
    {
        $this->roles[] = self::$rolesDefinition['admin'];
    }

    /**
     * @return void
     * Demote admin to normal user
     */
    public function demotion(): void
    {
        $this->roles = array_diff($this->roles, [self::$rolesDefinition['admin']]);
    }
}
