<?php

namespace App\Enum\Study\Dictionary;

use App\Entity\Dto\ReviewDataDto;
use App\Enum\DictionaryEnum;
use App\Enum\DictionaryInterface;
use App\Enum\ErrorType;
use App\Enum\ExtendedEnum;

enum MeasurementOccasionDictionary: string implements DictionaryInterface
{
    use ExtendedEnum;
    use DictionaryEnum;

    case TIME_OF_MEASUREMENT = 'timeOfMeasurement';
    case INTERVENTION = 'intervention';
    case POSITION = 'position';

    public function label(): string
    {
        return match ($this) {
            self::TIME_OF_MEASUREMENT => 'measurement_occasion.time_of_measurement.label',
            self::INTERVENTION => 'measurement_occasion.intervention.label',
            self::POSITION => 'measurement_occasion.position.label',
        };
    }

    public function reviewData(): ReviewDataDto
    {
        return match ($this) {
            self::TIME_OF_MEASUREMENT => new ReviewDataDto('measurement_occasion.time_of_measurement.error_message', ErrorType::MANDATORY),
            self::INTERVENTION => new ReviewDataDto('measurement_occasion.intervention.error_message', ErrorType::OPTIONAL),
            self::POSITION => new ReviewDataDto('measurement_occasion.position.error_message', ErrorType::OPTIONAL),
        };
    }
}
