<?php

namespace App\Domain\Definition;

class UserRoles
{
    const USER = "ROLE_USER";
    const REVIEWER = "ROLE_REVIEWER";
    const ADMINISTRATOR = "ROLE_ADMIN";

    public static function getAll(bool $withUserRole = true): array
    {
        return array_filter([
                                $withUserRole ? self::USER : null,
                                self::REVIEWER,
                                self::ADMINISTRATOR,
                            ]);
    }
}