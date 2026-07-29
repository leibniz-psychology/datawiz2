<?php

declare(strict_types=1);

namespace App\Enum\DataManagementPlan;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum ThirdPartyAccess: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case REPOSITORY = 'Repository or archive';
    case ON_DEMAND = 'On demand';
    case NONE = 'None';

    public function label(): string
    {
        return match ($this) {
            self::REPOSITORY => 'data_management_plan.third_party_access.repository',
            self::ON_DEMAND => 'data_management_plan.third_party_access.on_demand',
            self::NONE => 'data_management_plan.third_party_access.none',
        };
    }
}
