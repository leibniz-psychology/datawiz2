<?php

namespace App\Enum;

enum ErrorType: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case MANDATORY = 'mandatory';
    case RECOMMENDED = 'recommended';
    case OPTIONAL = 'optional';
}
