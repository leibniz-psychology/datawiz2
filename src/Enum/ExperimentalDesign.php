<?php

namespace App\Enum;

enum ExperimentalDesign: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case INDEPENDENT_MEASURES = 'Independent measures / between-subjects design';
    case REPEATED_MEASURES = 'Repeated measures / within-subjects design';
    case MATCHED_PAIRS = 'Matched pairs design';

    public function label(): string
    {
        return match ($this) {
            self::INDEPENDENT_MEASURES => 'experimental_design.independent_measures',
            self::REPEATED_MEASURES => 'experimental_design.repeated_measures',
            self::MATCHED_PAIRS => 'experimental_design.matched_pairs',
        };
    }

    public function labelExtended(): string
    {
        return match ($this) {
            self::INDEPENDENT_MEASURES => 'experimental_design.extended.independent_measures',
            self::REPEATED_MEASURES => 'experimental_design.extended.repeated_measures',
            self::MATCHED_PAIRS => 'experimental_design.extended.matched_pairs',
        };
    }
}
