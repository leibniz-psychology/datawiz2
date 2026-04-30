<?php

namespace App\Enum\Study;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum StudySetting: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case ARTIFICIAL = 'Artificial setting';
    case REAL_LIFE = 'Real-life setting';
    case NATURAL = 'Natural setting';

    public function label(): string
    {
        return match ($this) {
            self::ARTIFICIAL => 'study_setting.artificial',
            self::REAL_LIFE => 'study_setting.real_life',
            self::NATURAL => 'study_setting.natural',
        };
    }

    public function labelExtended(): string
    {
        return match ($this) {
            self::ARTIFICIAL => 'study_setting.extended.artificial',
            self::REAL_LIFE => 'study_setting.extended.real_life',
            self::NATURAL => 'study_setting.extended.natural',
        };
    }
}
