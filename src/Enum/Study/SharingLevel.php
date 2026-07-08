<?php

namespace App\Enum\Study;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum SharingLevel: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case PUBLIC = 'public';
    case SCIENTIFIC = 'scientific';
    case RESTRICTED_SCIENTIFIC = 'restricted scientific';
    case SECURE = 'secure';

    public function label(): string
    {
        return match ($this) {
            self::PUBLIC => 'sharing_level.public',
            self::SCIENTIFIC => 'sharing_level.scientific',
            self::RESTRICTED_SCIENTIFIC => 'sharing_level.restricted_scientific',
            self::SECURE => 'sharing_level.secure',
        };
    }

    public function labelExtended(): string
    {
        return match ($this) {
            self::PUBLIC => 'sharing_level.extended.public',
            self::SCIENTIFIC => 'sharing_level.extended.scientific',
            self::RESTRICTED_SCIENTIFIC => 'sharing_level.extended.restricted_scientific',
            self::SECURE => 'sharing_level.extended.secure',
        };
    }
}
