<?php

namespace App\Enum;

enum YesNo: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case NO = 'no';
    case YES = 'yes';

    public function label(): string
    {
        return match ($this) {
            self::NO => 'yes_no.no',
            self::YES => 'yes_no.yes',
        };
    }
}
