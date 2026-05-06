<?php

namespace App\Enum\Study\Dictionary;

use App\Enum\DictionaryEnum;
use App\Enum\DictionaryInterface;
use App\Enum\ExtendedEnum;

enum SampleDictionary: string implements DictionaryInterface
{
    use ExtendedEnum;
    use DictionaryEnum;

    case PARTICIPANTS = 'participants';
    case INCLUSION_CRITERIA = 'inclusionCriteria';
    case EXCLUSION_CRITERIA = 'exclusionCriteria';
    case POPULATION = 'population';
    case SAMPLING_METHOD = 'samplingMethod';
    case SAMPLING_METHOD_OTHER_DESCRIPTION = 'samplingMethodOtherDescription';
    case RECRUITING = 'recruiting';
    case SAMPLE_SIZE = 'sampleSize';
    case POWER_ANALYSIS = 'powerAnalysis';
    case INTENDED_SAMPLE_SIZE = 'intendedSampleSize';
    case UNIT_OF_ANALYSIS = 'unitOfAnalysis';
    case UNIT_OF_ANALYSIS_OTHER_DESCRIPTION = 'unitOfAnalysisOtherDescription';
    case MULTILEVEL_STRUCTURE = 'multilevelStructure';
    case SEX = 'sex';
    case AGE = 'age';
    case SPECIAL_GROUPS = 'specialGroups';
    case COUNTRY = 'country';
    case CITY = 'city';
    case REGION = 'region';
    case MISSING_VALUES = 'missingValues';
    case RETURN_DROPOUT = 'returnDropout';

    public function legend(): string
    {
        return match ($this) {
            self::PARTICIPANTS => 'sample_meta_data_group.participants.legend',
            self::INCLUSION_CRITERIA => 'sample_meta_data_group.inclusion_criteria.legend',
            self::EXCLUSION_CRITERIA => 'sample_meta_data_group.exclusion_criteria.legend',
            self::POPULATION => 'sample_meta_data_group.population.legend',
            self::SAMPLING_METHOD => 'sample_meta_data_group.sampling_method.legend',
            self::RECRUITING => 'sample_meta_data_group.recruiting.legend',
            self::SAMPLE_SIZE => 'sample_meta_data_group.sample_size.legend',
            self::POWER_ANALYSIS => 'sample_meta_data_group.power_analysis.legend',
            self::INTENDED_SAMPLE_SIZE => 'sample_meta_data_group.intended_sample_size.legend',
            self::UNIT_OF_ANALYSIS => 'sample_meta_data_group.unit_of_analysis.legend',
            self::MULTILEVEL_STRUCTURE => 'sample_meta_data_group.multilevel_structure.legend',
            self::SEX => 'sample_meta_data_group.sex.legend',
            self::AGE => 'sample_meta_data_group.age.legend',
            self::SPECIAL_GROUPS => 'sample_meta_data_group.special_groups.legend',
            self::COUNTRY => 'sample_meta_data_group.country.legend',
            self::MISSING_VALUES => 'sample_meta_data_group.missing_values.legend',
            self::RETURN_DROPOUT => 'sample_meta_data_group.return_dropout.legend',
            default => '',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::PARTICIPANTS => 'sample_meta_data_group.participants.label',
            self::INCLUSION_CRITERIA => 'sample_meta_data_group.inclusion_criteria.label',
            self::EXCLUSION_CRITERIA => 'sample_meta_data_group.exclusion_criteria.label',
            self::POPULATION => 'sample_meta_data_group.population.label',
            self::SAMPLING_METHOD => 'sample_meta_data_group.sampling_method.label',
            self::SAMPLING_METHOD_OTHER_DESCRIPTION => 'sample_meta_data_group.sampling_method_other_description.label',
            self::RECRUITING => 'sample_meta_data_group.recruiting.label',
            self::SAMPLE_SIZE => 'sample_meta_data_group.sample_size.label',
            self::POWER_ANALYSIS => 'sample_meta_data_group.power_analysis.label',
            self::INTENDED_SAMPLE_SIZE => 'sample_meta_data_group.intended_sample_size.label',
            self::UNIT_OF_ANALYSIS => 'sample_meta_data_group.unit_of_analysis.label',
            self::UNIT_OF_ANALYSIS_OTHER_DESCRIPTION => 'sample_meta_data_group.unit_of_analysis_other_description.label',
            self::MULTILEVEL_STRUCTURE => 'sample_meta_data_group.multilevel_structure.label',
            self::SEX => 'sample_meta_data_group.sex.label',
            self::AGE => 'sample_meta_data_group.age.label',
            self::SPECIAL_GROUPS => 'sample_meta_data_group.special_groups.label',
            self::COUNTRY => 'sample_meta_data_group.country.label',
            self::CITY => 'sample_meta_data_group.city.label',
            self::REGION => 'sample_meta_data_group.region.label',
            self::MISSING_VALUES => 'sample_meta_data_group.missing_values.label',
            self::RETURN_DROPOUT => 'sample_meta_data_group.return_dropout.label',
        };
    }

    public function descriptionHelp(): ?string
    {
        return match ($this) {
            self::PARTICIPANTS => 'sample.participants',
            self::INCLUSION_CRITERIA => 'sample.inclusion_criteria',
            self::EXCLUSION_CRITERIA => 'sample.exclusion_criteria',
            self::POPULATION => 'sample.population',
            self::SAMPLE_SIZE => 'sample.sample_size',
            self::POWER_ANALYSIS => 'sample.power_analysis',
            self::SAMPLING_METHOD => 'sample.sampling_method',
            self::RECRUITING => 'sample.recruiting',
            self::MULTILEVEL_STRUCTURE => 'sample.multilevel_structure',
            self::MISSING_VALUES => 'sample.missing_values',
            self::RETURN_DROPOUT => 'sample.return_dropout',
            default => null,
        };
    }
}
