<?php

namespace App\Enum\Study;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum ExperimentalDesign: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case REPEATED_MEASURES = 'Repeated measures';
    case GROUP_COMPARISON = 'Group comparison';
    case MIXED = 'Mixed';

    public function label(): string
    {
        return match ($this) {
            self::REPEATED_MEASURES => 'experimental_design.repeated_measures',
            self::GROUP_COMPARISON => 'experimental_design.group_comparison',
            self::MIXED => 'experimental_design.mixed',
        };
    }

    public function labelExtended(): string
    {
        return match ($this) {
            self::REPEATED_MEASURES => 'experimental_design.extended.repeated_measures',
            self::GROUP_COMPARISON => 'experimental_design.extended.group_comparison',
            self::MIXED => 'experimental_design.extended.mixed',
        };
    }
}
