<?php

namespace App\Enum\Study;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum ExperimentalDetails: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case EXPERIMENTAL = 'Experimental';
    case QUASI_EXPERIMENTAL = 'Quasi-experimental';

    public function label(): string
    {
        return match ($this) {
            self::EXPERIMENTAL => 'experimental_details.experimental',
            self::QUASI_EXPERIMENTAL => 'experimental_details.quasi_experimental',
        };
    }
}
