<?php

namespace App\Enum\DataManagementPlan;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum ExistingDataReuse: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case YES = 'yes';
    case NONE_FOUND = 'none found';
    case NO = 'no';

    public function label(): string
    {
        return match ($this) {
            self::YES => 'data_management_plan.existing_data_reuse.yes',
            self::NONE_FOUND => 'data_management_plan.existing_data_reuse.none_found',
            self::NO => 'data_management_plan.existing_data_reuse.no',
        };
    }
}
