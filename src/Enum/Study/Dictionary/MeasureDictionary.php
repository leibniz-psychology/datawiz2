<?php

namespace App\Enum\Study\Dictionary;

use App\Entity\Dto\ReviewDataDto;
use App\Enum\DictionaryEnum;
use App\Enum\DictionaryInterface;
use App\Enum\ErrorType;
use App\Enum\ExtendedEnum;

enum MeasureDictionary: string implements DictionaryInterface
{
    use ExtendedEnum;
    use DictionaryEnum;

    case DATA_COLLECTION_START = 'dataCollectionStart';
    case DATA_COLLECTION_END = 'dataCollectionEnd';
    case COLLECTION_MODE = 'collectionMode';
    case COLLECTION_INVESTIGATOR_PRESENCE = 'collectionInvestigatorPresence';
    case APPARATUS = 'apparatus';
    case COLLECTION_MODE_OTHER_DESCRIPTION = 'collectionModeOtherDescription';
    case ORIGINAL_RECORD_TYPE = 'originalRecordType';
    case ORIGINAL_RECORD_TYPE_OTHER_DESCRIPTION = 'originalRecordTypeOtherDescription';
    case RAW_DATA_DIGITIZATION = 'rawDataDigitization';
    case RAW_DATA_DIGITIZATION_DESCRIPTION = 'rawDataDigitizationDescription';
    case SPECIAL_CIRCUMSTANCES = 'specialCircumstances';
    case RAW_DATA_TRANSFORMATION = 'rawDataTransformation';
    case QUALITY_INDICATORS = 'qualityIndicators';
    case LIMITATIONS = 'limitations';

    public function legend(): string
    {
        return match ($this) {
            self::DATA_COLLECTION_START => 'measure_meta_data_group.data_collection_start.legend',
            self::DATA_COLLECTION_END => 'measure_meta_data_group.data_collection_end.legend',
            self::COLLECTION_MODE => 'measure_meta_data_group.collection_mode.legend',
            self::COLLECTION_INVESTIGATOR_PRESENCE => 'measure_meta_data_group.collection_investigator_presence.legend',
            self::APPARATUS => 'measure_meta_data_group.apparatus.legend',
            self::COLLECTION_MODE_OTHER_DESCRIPTION => 'measure_meta_data_group.collection_mode_other_description.legend',
            self::ORIGINAL_RECORD_TYPE => 'measure_meta_data_group.original_record_type.legend',
            self::ORIGINAL_RECORD_TYPE_OTHER_DESCRIPTION => 'measure_meta_data_group.original_record_type_other_description.legend',
            self::RAW_DATA_DIGITIZATION => 'measure_meta_data_group.raw_data_digitization.legend',
            self::RAW_DATA_DIGITIZATION_DESCRIPTION => 'measure_meta_data_group.raw_data_digitization_description.legend',
            self::SPECIAL_CIRCUMSTANCES => 'measure_meta_data_group.special_circumstances.legend',
            self::RAW_DATA_TRANSFORMATION => 'measure_meta_data_group.raw_data_transformation.legend',
            self::QUALITY_INDICATORS => 'measure_meta_data_group.quality_indicators.legend',
            self::LIMITATIONS => 'measure_meta_data_group.limitations.legend',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::DATA_COLLECTION_START => 'measure_meta_data_group.data_collection_start.label',
            self::DATA_COLLECTION_END => 'measure_meta_data_group.data_collection_end.label',
            self::COLLECTION_MODE => 'measure_meta_data_group.collection_mode.label',
            self::COLLECTION_INVESTIGATOR_PRESENCE => 'measure_meta_data_group.collection_investigator_presence.label',
            self::APPARATUS => 'measure_meta_data_group.apparatus.label',
            self::COLLECTION_MODE_OTHER_DESCRIPTION => 'measure_meta_data_group.collection_mode_other_description.label',
            self::ORIGINAL_RECORD_TYPE => 'measure_meta_data_group.original_record_type.label',
            self::ORIGINAL_RECORD_TYPE_OTHER_DESCRIPTION => 'measure_meta_data_group.original_record_type_other_description.label',
            self::RAW_DATA_DIGITIZATION => 'measure_meta_data_group.raw_data_digitization.label',
            self::RAW_DATA_DIGITIZATION_DESCRIPTION => 'measure_meta_data_group.raw_data_digitization_description.label',
            self::SPECIAL_CIRCUMSTANCES => 'measure_meta_data_group.special_circumstances.label',
            self::RAW_DATA_TRANSFORMATION => 'measure_meta_data_group.raw_data_transformation.label',
            self::QUALITY_INDICATORS => 'measure_meta_data_group.quality_indicators.label',
            self::LIMITATIONS => 'measure_meta_data_group.limitations.label',
        };
    }

    public function descriptionHelp(): ?string
    {
        return match ($this) {
            self::COLLECTION_MODE => 'measure.collection_mode',
            self::SPECIAL_CIRCUMSTANCES => 'measure.special_circumstances',
            self::RAW_DATA_TRANSFORMATION => 'measure.raw_data_transformation',
            self::QUALITY_INDICATORS => 'measure.quality_indicators',
            self::LIMITATIONS => 'measure.limitations',
            default => null,
        };
    }

    public function reviewData(): ReviewDataDto
    {
        return match ($this) {
            self::DATA_COLLECTION_START => new ReviewDataDto('measure_meta_data_group.data_collection_start.error_message', ErrorType::RECOMMENDED),
            self::DATA_COLLECTION_END => new ReviewDataDto('measure_meta_data_group.data_collection_end.error_message', ErrorType::RECOMMENDED),
            self::COLLECTION_MODE => new ReviewDataDto('measure_meta_data_group.collection_mode.error_message', ErrorType::RECOMMENDED),
            self::COLLECTION_INVESTIGATOR_PRESENCE => new ReviewDataDto('measure_meta_data_group.collection_investigator_presence.error_message', ErrorType::RECOMMENDED),
            self::APPARATUS => new ReviewDataDto('measure_meta_data_group.apparatus.error_message', ErrorType::RECOMMENDED),
            self::COLLECTION_MODE_OTHER_DESCRIPTION => new ReviewDataDto('measure_meta_data_group.collection_mode_other_description.error_message', ErrorType::OPTIONAL),
            self::ORIGINAL_RECORD_TYPE => new ReviewDataDto('measure_meta_data_group.original_record_type.error_message', ErrorType::RECOMMENDED),
            self::ORIGINAL_RECORD_TYPE_OTHER_DESCRIPTION => new ReviewDataDto('measure_meta_data_group.original_record_type_other_description.error_message', ErrorType::OPTIONAL),
            self::RAW_DATA_DIGITIZATION => new ReviewDataDto('measure_meta_data_group.raw_data_digitization.error_message', ErrorType::RECOMMENDED),
            self::RAW_DATA_DIGITIZATION_DESCRIPTION => new ReviewDataDto('measure_meta_data_group.raw_data_digitization_description.error_message', ErrorType::OPTIONAL),
            self::SPECIAL_CIRCUMSTANCES => new ReviewDataDto('measure_meta_data_group.special_circumstances.error_message', ErrorType::RECOMMENDED),
            self::RAW_DATA_TRANSFORMATION => new ReviewDataDto('measure_meta_data_group.raw_data_transformation.error_message', ErrorType::RECOMMENDED),
            self::QUALITY_INDICATORS => new ReviewDataDto('measure_meta_data_group.quality_indicators.error_message', ErrorType::RECOMMENDED),
            self::LIMITATIONS => new ReviewDataDto('measure_meta_data_group.limitations.error_message', ErrorType::RECOMMENDED),
        };
    }
}
