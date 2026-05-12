<?php

namespace App\Enum\Study;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum ResearchMethod: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case EXPERIMENTAL = 'Experimental';
    case SURVEY = 'Survey';
    case TEST_DEVELOPMENT = 'Test development';

    public function label(): string
    {
        return match ($this) {
            self::EXPERIMENTAL => 'research_method.experimental',
            self::SURVEY => 'research_method.survey',
            self::TEST_DEVELOPMENT => 'research_method.test_development',
        };
    }

    public function labelExtended(): string
    {
        return match ($this) {
            self::EXPERIMENTAL => 'research_method.extended.experimental',
            self::SURVEY => 'research_method.extended.non_experimental',
            self::TEST_DEVELOPMENT => 'research_method.extended.test_development',
        };
    }
}
