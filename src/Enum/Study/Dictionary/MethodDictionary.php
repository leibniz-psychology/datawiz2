<?php

namespace App\Enum\Study\Dictionary;

use App\Entity\Dto\ReviewDataDto;
use App\Enum\DictionaryEnum;
use App\Enum\DictionaryInterface;
use App\Enum\ErrorType;
use App\Enum\ExtendedEnum;

enum MethodDictionary: string implements DictionaryInterface
{
    use ExtendedEnum;
    use DictionaryEnum;

    case RESEARCH_DESIGN = 'researchDesign';
    case RESEARCH_METHOD = 'researchMethod';
    case EXPERIMENTAL_DETAILS = 'experimentalDetails';
    case NON_EXPERIMENTAL_DETAILS = 'nonExperimentalDetails';
    case OBSERVATIONAL_TYPE = 'observationalType';
    case MANIPULATIONS = 'manipulations';
    case EXPERIMENTAL_DESIGN = 'experimentalDesign';
    case CONTROL_OPERATIONS = 'controlOperations';
    case OTHER_CONTROL_OPERATIONS = 'otherControlOperations';
    case SETTING = 'setting';
    case SETTING_LOCATION = 'settingLocation';
    case RESEARCH_DESIGN_DESCRIPTION = 'researchDesignDescription';
    case SURVEY_INSTRUMENT_TYPE = 'surveyInstrumentType';
    case TREATMENT_GROUPS = 'treatmentGroups';
    case RESEARCH_METHOD_DESCRIPTION = 'researchMethodDescription';
    case MEASUREMENT_OCCASIONS = 'measurementOccasions';
    case CONSTRUCTS = 'constructs';
    case MEASUREMENT_INSTRUMENTS = 'measurementInstruments';

    public function legend(): string
    {
        return match ($this) {
            self::RESEARCH_DESIGN => 'method_meta_data_group.research_design.legend',
            self::RESEARCH_METHOD => 'method_meta_data_group.research_method.legend',
            self::EXPERIMENTAL_DETAILS => 'method_meta_data_group.experimental_details.legend',
            self::NON_EXPERIMENTAL_DETAILS => 'method_meta_data_group.non_experimental_details.legend',
            self::SETTING => 'method_meta_data_group.setting.legend',
            self::SETTING_LOCATION => 'method_meta_data_group.setting_location.legend',
            self::OBSERVATIONAL_TYPE => 'method_meta_data_group.observational_type.legend',
            self::MANIPULATIONS => 'method_meta_data_group.manipulations.legend',
            self::EXPERIMENTAL_DESIGN => 'method_meta_data_group.experimental_design.legend',
            self::CONTROL_OPERATIONS => 'method_meta_data_group.control_operations.legend',
            self::OTHER_CONTROL_OPERATIONS => 'method_meta_data_group.other_control_operations.legend',
            self::RESEARCH_DESIGN_DESCRIPTION => 'method_meta_data_group.research_design_description.legend',
            self::SURVEY_INSTRUMENT_TYPE => 'method_meta_data_group.survey_instrument_type.legend',
            self::TREATMENT_GROUPS => 'method_meta_data_group.treatment_groups.legend',
            self::RESEARCH_METHOD_DESCRIPTION => 'method_meta_data_group.research_method_description.legend',
            self::MEASUREMENT_OCCASIONS => 'method_meta_data_group.measurement_occasions.legend',
            self::CONSTRUCTS => 'method_meta_data_group.constructs.legend',
            self::MEASUREMENT_INSTRUMENTS => 'method_meta_data_group.measurement_instruments.legend',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::RESEARCH_METHOD => 'method_meta_data_group.research_method.label',
            self::EXPERIMENTAL_DETAILS => 'method_meta_data_group.experimental_details.label',
            self::NON_EXPERIMENTAL_DETAILS => 'method_meta_data_group.non_experimental_details.label',
            self::SETTING => 'method_meta_data_group.setting.label',
            self::SETTING_LOCATION => 'method_meta_data_group.setting_location.label',
            self::OBSERVATIONAL_TYPE => 'method_meta_data_group.observational_type.label',
            self::MANIPULATIONS => 'method_meta_data_group.manipulations.label',
            self::EXPERIMENTAL_DESIGN => 'method_meta_data_group.experimental_design.label',
            self::CONTROL_OPERATIONS => 'method_meta_data_group.control_operations.label',
            self::OTHER_CONTROL_OPERATIONS => 'method_meta_data_group.other_control_operations.label',
            self::RESEARCH_DESIGN => 'method_meta_data_group.research_design.label',
            self::RESEARCH_DESIGN_DESCRIPTION => 'method_meta_data_group.research_design_description.label',
            self::SURVEY_INSTRUMENT_TYPE => 'method_meta_data_group.survey_instrument_type.label',
            self::TREATMENT_GROUPS => 'method_meta_data_group.treatment_groups.label',
            self::RESEARCH_METHOD_DESCRIPTION => 'method_meta_data_group.research_method_description.label',
            self::MEASUREMENT_OCCASIONS => 'method_meta_data_group.measurement_occasions.label',
            self::CONSTRUCTS => 'method_meta_data_group.constructs.label',
            self::MEASUREMENT_INSTRUMENTS => 'method_meta_data_group.measurement_instruments.label',
        };
    }

    public function placeholder(): ?string
    {
        return match ($this) {
            self::OBSERVATIONAL_TYPE => 'method_meta_data_group.observational_type.placeholder',
            self::SURVEY_INSTRUMENT_TYPE => 'method_meta_data_group.survey_instrument_type.placeholder',
            default => null,
        };
    }

    public function help(): ?string
    {
        return match ($this) {
            self::RESEARCH_DESIGN_DESCRIPTION => 'method_meta_data_group.research_design_description.help',
            default => null,
        };
    }

    public function descriptionHelp(): ?string
    {
        return match ($this) {
            self::RESEARCH_DESIGN => 'method.research_design',
            self::RESEARCH_METHOD => 'method.research_method',
            self::SETTING => 'method.setting',
            self::MANIPULATIONS => 'method.manipulations',
            self::EXPERIMENTAL_DESIGN => 'method.experimental_design',
            self::CONTROL_OPERATIONS => 'method.control_operations',
            self::RESEARCH_METHOD_DESCRIPTION => 'method.research_method_description',
            self::CONSTRUCTS => 'method.constructs',
            default => null,
        };
    }

    public function reviewData(): ReviewDataDto
    {
        return match ($this) {
            self::RESEARCH_METHOD => new ReviewDataDto('method_meta_data_group.name.error_message', ErrorType::MANDATORY),
            self::EXPERIMENTAL_DETAILS => new ReviewDataDto('method_meta_data_group.experimental_details.error_message', ErrorType::OPTIONAL),
            self::NON_EXPERIMENTAL_DETAILS => new ReviewDataDto('method_meta_data_group.non_experimental_details.error_message', ErrorType::OPTIONAL),
            self::SETTING => new ReviewDataDto('method_meta_data_group.setting.error_message', ErrorType::OPTIONAL),
            self::SETTING_LOCATION => new ReviewDataDto('method_meta_data_group.setting_location.error_message', ErrorType::OPTIONAL),
            self::OBSERVATIONAL_TYPE => new ReviewDataDto('method_meta_data_group.observational_type.error_message', ErrorType::OPTIONAL),
            self::MANIPULATIONS => new ReviewDataDto('method_meta_data_group.manipulations.error_message', ErrorType::OPTIONAL),
            self::EXPERIMENTAL_DESIGN => new ReviewDataDto('method_meta_data_group.experimental_design.error_message', ErrorType::OPTIONAL),
            self::CONTROL_OPERATIONS => new ReviewDataDto('method_meta_data_group.control_operations.error_message', ErrorType::OPTIONAL),
            self::OTHER_CONTROL_OPERATIONS => new ReviewDataDto('method_meta_data_group.other_control_operations.error_message', ErrorType::OPTIONAL),
            self::RESEARCH_DESIGN => new ReviewDataDto('method_meta_data_group.research_design.error_message', ErrorType::OPTIONAL),
            self::RESEARCH_DESIGN_DESCRIPTION => new ReviewDataDto('method_meta_data_group.research_design_description.error_message', ErrorType::OPTIONAL),
            self::SURVEY_INSTRUMENT_TYPE => new ReviewDataDto('method_meta_data_group.survey_instrument_type.error_message', ErrorType::OPTIONAL),
            self::TREATMENT_GROUPS => new ReviewDataDto('method_meta_data_group.treatment_groups.error_message', ErrorType::OPTIONAL),
            self::RESEARCH_METHOD_DESCRIPTION => new ReviewDataDto('method_meta_data_group.research_method_description.error_message', ErrorType::OPTIONAL),
            self::MEASUREMENT_OCCASIONS => new ReviewDataDto('method_meta_data_group.measurement_occasions.error_message', ErrorType::OPTIONAL),
            self::CONSTRUCTS => new ReviewDataDto('method_meta_data_group.constructs.error_message', ErrorType::OPTIONAL),
            self::MEASUREMENT_INSTRUMENTS => new ReviewDataDto('method_meta_data_group.measurement_instruments.error_message', ErrorType::OPTIONAL),
        };
    }
}
