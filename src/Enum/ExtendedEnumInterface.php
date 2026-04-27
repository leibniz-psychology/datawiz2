<?php

namespace App\Enum;

interface ExtendedEnumInterface
{
    /**
     * @return string[]
     */
    public static function values(): array;

    public function label(): string;
}
