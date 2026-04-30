<?php

namespace App\Enum\Study\Dictionary;

use App\Enum\DictionaryEnum;
use App\Enum\DictionaryInterface;
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
}
