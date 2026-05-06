<?php

namespace App\Enum\Study;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum DataDigitization: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case SIMPLE = 'Simple';
    case COMPLEX = 'Complex';

    public function label(): string
    {
        return match ($this) {
            self::SIMPLE => 'data_digitization.simple',
            self::COMPLEX => 'data_digitization.complex',
        };
    }
}
