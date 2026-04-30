<?php

namespace App\Enum\Study;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum SurveyInstrumentType: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case FULLY_STANDARDIZED = 'Fullly standardized';
    case PARTIALLY_STANDARDIZED = 'Partially standardized';
    case HARDLY_STANDARDIZED = 'Hardly standardized';
    case MIXED = 'Mixed';

    public function label(): string
    {
        return match ($this) {
            self::FULLY_STANDARDIZED => 'survey_instrument_type.fully_standardized',
            self::PARTIALLY_STANDARDIZED => 'survey_instrument_type.partially_standardized',
            self::HARDLY_STANDARDIZED => 'survey_instrument_type.hardly_standardized',
            self::MIXED => 'survey_instrument_type.mixed',
        };
    }

    public function labelExtended(): string
    {
        return match ($this) {
            self::FULLY_STANDARDIZED => 'survey_instrument_type.extended.fully_standardized',
            self::PARTIALLY_STANDARDIZED => 'survey_instrument_type.extended.partially_standardized',
            self::HARDLY_STANDARDIZED => 'survey_instrument_type.extended.hardly_standardized',
            self::MIXED => 'survey_instrument_type.extended.mixed',
        };
    }
}
