<?php

namespace App\Enum\Study;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum NonExperimentalDetails: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case OBSERVATIONAL_STUDY = 'Observational study';
    case SURVEY_RESEARCH = 'Survey research';
    case CORRELATIONAL_RESEARCH = 'Correlational research';
    case CAUSAL_COMPARATIVE_RESEARCH = 'Causal-comparative research';
    case SINGLE_CASE = 'Single case';

    public function label(): string
    {
        return match ($this) {
            self::OBSERVATIONAL_STUDY => 'non_experimental_details.observational_study',
            self::SURVEY_RESEARCH => 'non_experimental_details.survey_research',
            self::CORRELATIONAL_RESEARCH => 'non_experimental_details.correlational_research',
            self::CAUSAL_COMPARATIVE_RESEARCH => 'non_experimental_details.causal_comparative_research',
            self::SINGLE_CASE => 'non_experimental_details.single_case',
        };
    }

    public function labelExtended(): string
    {
        return match ($this) {
            self::OBSERVATIONAL_STUDY => 'non_experimental_details.extended.observational_study',
            self::SURVEY_RESEARCH => 'non_experimental_details.extended.survey_research',
            self::CORRELATIONAL_RESEARCH => 'non_experimental_details.extended.correlational_research',
            self::CAUSAL_COMPARATIVE_RESEARCH => 'non_experimental_details.extended.causal_comparative_research',
            self::SINGLE_CASE => 'non_experimental_details.extended.single_case',
        };
    }
}
