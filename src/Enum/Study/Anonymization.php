<?php

namespace App\Enum\Study;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum Anonymization: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case ANONYMIZED = 'anonymized';
    case NOT_ANONYMIZED = 'Not anonymized';

    public function label(): string
    {
        return match ($this) {
            self::ANONYMIZED => 'anonymization.anonymized',
            self::NOT_ANONYMIZED => 'anonymization.not_anonymized',
        };
    }

    public function labelExtended(): string
    {
        return match ($this) {
            self::ANONYMIZED => 'anonymization.extended.anonymized',
            self::NOT_ANONYMIZED => 'anonymization.extended.not_anonymized',
        };
    }
}
