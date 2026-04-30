<?php

namespace App\Enum\Study;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum ConstructFunction: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case INDEPENDENT_VARIABLE = 'Independent variable';
    case DEPENDENT_VARIABLE = 'Dependent variable';
    case CONTROL_VARIABLE = 'Control variable';
    case OTHER = 'Other';

    public function label(): string
    {
        return match ($this) {
            self::INDEPENDENT_VARIABLE => 'construct_function.independent_variable',
            self::DEPENDENT_VARIABLE => 'construct_function.dependent_variable',
            self::CONTROL_VARIABLE => 'construct_function.control_variable',
            self::OTHER => 'construct_function.other',
        };
    }
}
