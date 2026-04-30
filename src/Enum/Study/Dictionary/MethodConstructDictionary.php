<?php

namespace App\Enum\Study\Dictionary;

use App\Enum\DictionaryEnum;
use App\Enum\DictionaryInterface;
use App\Enum\ExtendedEnum;

enum MethodConstructDictionary: string implements DictionaryInterface
{
    use ExtendedEnum;
    use DictionaryEnum;

    case NAME = 'name';
    case CONSTRUCT_FUNCTION = 'constructFunction';
    case OTHER_FUNCTION_DESCRIPTION = 'otherFunctionDescription';

    public function label(): string
    {
        return match ($this) {
            self::NAME => 'method_construct.name.label',
            self::CONSTRUCT_FUNCTION => 'method_construct.function.label',
            self::OTHER_FUNCTION_DESCRIPTION => 'method_construct.other_function_description.label',
        };
    }

    public function placeholder(): string
    {
        return match ($this) {
            self::CONSTRUCT_FUNCTION => 'method_construct.function.placeholder',
            default => null,
        };
    }
}
