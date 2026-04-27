<?php

namespace App\Enum;

trait ExtendedEnum
{
    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_map(fn ($role) => $role->value, self::cases());
    }

    /**
     * @return string[]
     */
    public static function labels(): array
    {
        return array_map(fn ($role) => $role->label(), self::cases());
    }

    public function label(): string
    {
        return $this->value;
    }
}
