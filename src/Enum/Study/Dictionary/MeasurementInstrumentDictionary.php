<?php

namespace App\Enum\Study\Dictionary;

use App\Enum\DictionaryEnum;
use App\Enum\DictionaryInterface;
use App\Enum\ExtendedEnum;

enum MeasurementInstrumentDictionary: string implements DictionaryInterface
{
    use ExtendedEnum;
    use DictionaryEnum;

    case TITLE = 'title';
    case AUTHOR = 'author';
    case CITATION = 'citation';
    case ABSTRACT = 'abstract';
    case THEORETICAL_BACKGROUND = 'theoreticalBackground';
    case STRUCTURE = 'structure';
    case DEVELOPMENT = 'development';
    case OBJECTIVITY = 'objectivity';
    case RELIABILITY = 'reliability';
    case VALIDITY = 'validity';
    case NORM_REFERENCED = 'normReferenced';

    public function label(): string
    {
        return match ($this) {
            self::TITLE => 'measurement_instrument.title.label',
            self::AUTHOR => 'measurement_instrument.author.label',
            self::CITATION => 'measurement_instrument.citation.label',
            self::ABSTRACT => 'measurement_instrument.abstract.label',
            self::THEORETICAL_BACKGROUND => 'measurement_instrument.theoretical_background.label',
            self::STRUCTURE => 'measurement_instrument.structure.label',
            self::DEVELOPMENT => 'measurement_instrument.development.label',
            self::OBJECTIVITY => 'measurement_instrument.objectivity.label',
            self::RELIABILITY => 'measurement_instrument.reliability.label',
            self::VALIDITY => 'measurement_instrument.validity.label',
            self::NORM_REFERENCED => 'measurement_instrument.norm_referenced.label',
        };
    }

    public function help(): ?string
    {
        return match ($this) {
            self::AUTHOR => 'measurement_instrument.author.help',
            self::ABSTRACT => 'measurement_instrument.abstract.help',
            self::THEORETICAL_BACKGROUND => 'measurement_instrument.theoretical_background.help',
            self::STRUCTURE => 'measurement_instrument.structure.help',
            self::DEVELOPMENT => 'measurement_instrument.development.help',
            self::OBJECTIVITY => 'measurement_instrument.objectivity.help',
            self::RELIABILITY => 'measurement_instrument.reliability.help',
            self::VALIDITY => 'measurement_instrument.validity.help',
            self::NORM_REFERENCED => 'measurement_instrument.norm_referenced.help',
            default => null,
        };
    }
}
