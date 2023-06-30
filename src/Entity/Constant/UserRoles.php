<?php

namespace App\Entity\Constant;

class UserRoles
{
    final public const USER = 'ROLE_USER';
    final public const REVIEWER = 'ROLE_REVIEWER';
    final public const ADMINISTRATOR = 'ROLE_ADMIN';

    public static function getAll(bool $withUserRole = true): array
    {
        return array_filter([
            $withUserRole ? self::USER : null,
            self::REVIEWER,
            self::ADMINISTRATOR,
        ]);
    }
}
