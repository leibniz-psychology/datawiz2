<?php

namespace App\Enum\Study\Dictionary;

use App\Entity\Dto\ReviewDataDto;
use App\Enum\DictionaryEnum;
use App\Enum\DictionaryInterface;
use App\Enum\ErrorType;
use App\Enum\ExtendedEnum;

enum MeasurementInstrumentDictionary: string implements DictionaryInterface
{
    use ExtendedEnum;
    use DictionaryEnum;

    case TITLE = 'title';
    case AUTHOR = 'author';
    case CITATION = 'citation';
    case NEWLY_DEVELOPED = 'newlyDeveloped';
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
            self::NEWLY_DEVELOPED => 'measurement_instrument.newly_developed.label',
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

    public function reviewData(): ReviewDataDto
    {
        return match ($this) {
            self::TITLE => new ReviewDataDto('measure_meta_data_group.title.error_message', ErrorType::MANDATORY),
            self::AUTHOR => new ReviewDataDto('measure_meta_data_group.author.error_message', ErrorType::RECOMMENDED),
            self::CITATION => new ReviewDataDto('measure_meta_data_group.citation.error_message', ErrorType::RECOMMENDED),
            self::NEWLY_DEVELOPED => new ReviewDataDto('measure_meta_data_group.newly_developed.error_message', ErrorType::OPTIONAL),
            self::ABSTRACT => new ReviewDataDto('measure_meta_data_group.abstract.error_message', ErrorType::OPTIONAL),
            self::THEORETICAL_BACKGROUND => new ReviewDataDto('measure_meta_data_group.theoretical_background.error_message', ErrorType::OPTIONAL),
            self::STRUCTURE => new ReviewDataDto('measure_meta_data_group.structure.error_message', ErrorType::OPTIONAL),
            self::DEVELOPMENT => new ReviewDataDto('measure_meta_data_group.development.error_message', ErrorType::OPTIONAL),
            self::OBJECTIVITY => new ReviewDataDto('measure_meta_data_group.objectivity.error_message', ErrorType::OPTIONAL),
            self::RELIABILITY => new ReviewDataDto('measure_meta_data_group.reliability.error_message', ErrorType::OPTIONAL),
            self::VALIDITY => new ReviewDataDto('measure_meta_data_group.validity.error_message', ErrorType::OPTIONAL),
            self::NORM_REFERENCED => new ReviewDataDto('measure_meta_data_group.norm_referenced.error_message', ErrorType::OPTIONAL),
        };
    }
}
