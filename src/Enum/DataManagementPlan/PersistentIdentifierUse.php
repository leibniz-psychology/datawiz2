<?php

declare(strict_types=1);

namespace App\Enum\DataManagementPlan;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum PersistentIdentifierUse: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case NO = 'No';
    case DOI = 'Doi';
    case OTHER = 'Other';

    public function label(): string
    {
        return match ($this) {
            self::NO => 'data_management_plan.persistent_identifier_use.no',
            self::DOI => 'data_management_plan.persistent_identifier_use.doi',
            self::OTHER => 'data_management_plan.persistent_identifier_use.other',
        };
    }
}
