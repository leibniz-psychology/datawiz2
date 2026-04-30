<?php

namespace App\Enum\Study;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum ExperimentalDetails: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case RANDOM_ASSIGNMENT = 'Random assignment';
    case NON_RANDOM_ASSIGNMENT = 'Non-random assignment';
    case CLINICAL_TRIAL = 'Clinical trial';

    public function label(): string
    {
        return match ($this) {
            self::RANDOM_ASSIGNMENT => 'experimental_details.random_assignment',
            self::NON_RANDOM_ASSIGNMENT => 'experimental_details.non_random_assignment',
            self::CLINICAL_TRIAL => 'experimental_details.clinical_trial',
        };
    }

    public function labelExtended(): string
    {
        return match ($this) {
            self::RANDOM_ASSIGNMENT => 'experimental_details.extended.random_assignment',
            self::NON_RANDOM_ASSIGNMENT => 'experimental_details.extended.non_random_assignment',
            self::CLINICAL_TRIAL => 'experimental_details.extended.clinical_trial',
        };
    }
}
