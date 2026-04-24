<?php

namespace App\Entity\Constant;

class UserRoles
{
    final public const string USER = 'ROLE_USER';
    final public const string REVIEWER = 'ROLE_REVIEWER';
    final public const string ADMINISTRATOR = 'ROLE_ADMIN';

    public static function getAll(bool $withUserRole = true): array
    {
        return array_filter([
            $withUserRole ? self::USER : null,
            self::REVIEWER,
            self::ADMINISTRATOR,
        ]);
    }
}
