<?php

declare(strict_types=1);

namespace App\Enum\DataManagementPlan;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum NoSharingExplanation: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case DATA_PROTECTION = 'Data protection';
    case CONFIDENTIALITY = 'Confidentiality';
    case OTHER = 'Other';

    public function label(): string
    {
        return match ($this) {
            self::DATA_PROTECTION => 'data_management_plan.no_sharing_explanation.data_protection',
            self::CONFIDENTIALITY => 'data_management_plan.no_sharing_explanation.confidentiality',
            self::OTHER => 'data_management_plan.no_sharing_explanation.other',
        };
    }
}
