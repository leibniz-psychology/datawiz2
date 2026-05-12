<?php

namespace App\Enum\Study;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum StudySetting: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case LABORATORY = 'Laboratory experiment';
    case FIELD = 'Field experiment';

    public function label(): string
    {
        return match ($this) {
            self::LABORATORY => 'study_setting.laboratory',
            self::FIELD => 'study_setting.field',
        };
    }

    public function labelExtended(): string
    {
        return match ($this) {
            self::LABORATORY => 'study_setting.extended.laboratory',
            self::FIELD => 'study_setting.extended.field',
        };
    }
}
