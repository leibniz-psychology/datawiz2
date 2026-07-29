<?php

namespace App\Enum\DataManagementPlan;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum ResearchMethod: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case EXPERIMENTAL = 'Experimental data';
    case SURVEY = 'Survey data';
    case TEST = 'Test data';
    case OTHER = 'Other';

    public function label(): string
    {
        return match ($this) {
            self::EXPERIMENTAL => 'data_management_plan.research_method.experimental',
            self::SURVEY => 'data_management_plan.research_method.survey',
            self::TEST => 'data_management_plan.research_method.test',
            self::OTHER => 'data_management_plan.research_method.other',
        };
    }

    public function labelExtended(): string
    {
        return match ($this) {
            self::EXPERIMENTAL => 'data_management_plan.research_method.extended.experimental',
            self::SURVEY => 'data_management_plan.research_method.extended.survey',
            self::TEST => 'data_management_plan.research_method.extended.test',
            self::OTHER => 'data_management_plan.research_method.extended.other',
        };
    }
}
