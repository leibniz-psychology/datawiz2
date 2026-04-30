<?php

namespace App\Enum\Study;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum DataStatus: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case COMPLETE = 'complete';
    case SUBSET = 'subset';

    public function label(): string
    {
        return match ($this) {
            self::COMPLETE => 'data_status.complete',
            self::SUBSET => 'data_status.subset',
        };
    }
}
