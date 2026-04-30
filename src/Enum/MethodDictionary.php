<?php

namespace App\Enum;

enum MethodDictionary: string implements DictionaryInterface
{
    use ExtendedEnum;
    use DictionaryEnum;

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

    public function legend(): string
    {
        return match ($this) {
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
        };
    }

    public function placeholder(): ?string
    {
        return match ($this) {
            self::OBSERVATIONAL_TYPE => 'method_meta_data_group.observational_type.placeholder',
            default => null,
        };
    }

    public function descriptionHelp(): ?string
    {
        return match ($this) {
            self::RESEARCH_METHOD => 'method.research_method',
            self::SETTING => 'method.setting',
            self::MANIPULATIONS => 'method.manipulations',
            self::EXPERIMENTAL_DESIGN => 'method.experimental_design',
            self::CONTROL_OPERATIONS => 'method.control_operations',
            default => null,
        };
    }
}
