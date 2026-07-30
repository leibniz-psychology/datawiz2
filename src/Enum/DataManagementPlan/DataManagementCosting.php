<?php

declare(strict_types=1);

namespace App\Enum\DataManagementPlan;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum DataManagementCosting: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case NO_COSTING = 'No costing';
    case BASED_ON_REFERENCE_VALUES = 'Costing based on reference values';
    case BASED_ON_LIFECYCLE_ANALYSIS = 'Costing based on lifecycle analysis';
    case BASED_ON_OTHER_METHODS = 'Costing based on other methods';

    public function label(): string
    {
        return match ($this) {
            self::NO_COSTING => 'data_management_plan.data_management_costing.no_costing',
            self::BASED_ON_REFERENCE_VALUES => 'data_management_plan.data_management_costing.based_on_reference_values',
            self::BASED_ON_LIFECYCLE_ANALYSIS => 'data_management_plan.data_management_costing.based_on_lifecycle_analysis',
            self::BASED_ON_OTHER_METHODS => 'data_management_plan.data_management_costing.based_on_other_methods',
        };
    }
}
