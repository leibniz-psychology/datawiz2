<?php

namespace App\Enum\Study\Dictionary;

use App\Entity\Dto\ReviewDataDto;
use App\Enum\DictionaryEnum;
use App\Enum\DictionaryInterface;
use App\Enum\ErrorType;
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

    public function reviewData(): ReviewDataDto
    {
        return match ($this) {
            self::NAME => new ReviewDataDto('method_construct.name.error_message', ErrorType::MANDATORY),
            self::CONSTRUCT_FUNCTION => new ReviewDataDto('method_construct.function.error_message', ErrorType::MANDATORY),
            self::OTHER_FUNCTION_DESCRIPTION => new ReviewDataDto('method_construct.other_function_description.error_message', ErrorType::OPTIONAL),
        };
    }
}
