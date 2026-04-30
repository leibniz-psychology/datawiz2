<?php

namespace App\Enum\Study;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum ObservationalType: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case COHORT = 'Cohort study';
    case CASE_CONTROL = 'Case-control study';
    case CROSS_SECTIONAL = 'Cross-sectional study';

    public function label(): string
    {
        return match ($this) {
            self::COHORT => 'observational_type.cohort',
            self::CASE_CONTROL => 'observational_type.case_control',
            self::CROSS_SECTIONAL => 'observational_type.cross_sectional',
        };
    }
}
