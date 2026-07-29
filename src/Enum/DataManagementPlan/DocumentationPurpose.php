<?php

declare(strict_types=1);

namespace App\Enum\DataManagementPlan;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum DocumentationPurpose: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case INTERPRETATION = 'interpretation';
    case EXCHANGE = 'exchange';
    case ADMINISTRATION = 'administration';

    public function label(): string
    {
        return match ($this) {
            self::INTERPRETATION => 'data_management_plan.documentation_purpose.interpretation',
            self::EXCHANGE => 'data_management_plan.documentation_purpose.exchange',
            self::ADMINISTRATION => 'data_management_plan.documentation_purpose.administration',
        };
    }

    public function labelExtended(): string
    {
        return match ($this) {
            self::INTERPRETATION => 'data_management_plan.documentation_purpose.extended.interpretation',
            self::EXCHANGE => 'data_management_plan.documentation_purpose.extended.exchange',
            self::ADMINISTRATION => 'data_management_plan.documentation_purpose.extended.administration',
        };
    }
}
