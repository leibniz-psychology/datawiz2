<?php

namespace App\Enum\Study;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum SampleAnalysisUnit: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case INDIVIDUALS = 'Individuals';
    case DYADS = 'Dyads';
    case FAMILIES = 'Families';
    case GROUPS = 'Groups';
    case ORGANIZATIONS = 'Organizations';
    case OTHER = 'Other';

    public function label(): string
    {
        return match ($this) {
            self::INDIVIDUALS => 'sample_analysis_unit.individuals',
            self::DYADS => 'sample_analysis_unit.dyads',
            self::FAMILIES => 'sample_analysis_unit.families',
            self::GROUPS => 'sample_analysis_unit.groups',
            self::ORGANIZATIONS => 'sample_analysis_unit.organizations',
            self::OTHER => 'sample_analysis_unit.other',
        };
    }
}
