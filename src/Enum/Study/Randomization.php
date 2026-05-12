<?php

namespace App\Enum\Study;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum Randomization: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case RANDOM_ASSIGNMENT = 'Random assignment';
    case NON_RANDOM_ASSIGNMENT = 'Non-random assignment';

    public function label(): string
    {
        return match ($this) {
            self::RANDOM_ASSIGNMENT => 'randomization.random_assignment',
            self::NON_RANDOM_ASSIGNMENT => 'randomization.non_random_assignment',
        };
    }

    public function labelExtended(): string
    {
        return match ($this) {
            self::RANDOM_ASSIGNMENT => 'randomization.extended.random_assignment',
            self::NON_RANDOM_ASSIGNMENT => 'randomization.extended.non_random_assignment',
        };
    }
}
