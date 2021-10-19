<?php

namespace App\Domain\Definition;

class ReviewDataDictionary
{
    /* BASIC */
    const TITLE = ['legend' => 'input.title.legend', 'errorMsg' => 'input.title.empty', 'errorLevel' => ErrorType::ERROR];
    const DESCRIPTION = ['legend' => 'input.description.legend', 'errorMsg' => 'input.description.empty', 'errorLevel' => ErrorType::ERROR];
    const RELATED_PUBS = ['legend' => 'input.relatedPubs.legend', 'errorMsg' => null, 'errorLevel' => ErrorType::NONE];
    /*CREATOR*/
    const CREATOR_GIVEN = ['legend' => 'input.creator.name.given', 'errorMsg' => 'input.creator.empty.given', 'errorLevel' => ErrorType::ERROR];
    const CREATOR_FAMILY = ['legend' => 'input.creator.name.family', 'errorMsg' => 'input.creator.empty.family', 'errorLevel' => ErrorType::ERROR];
    const CREATOR_EMAIL = ['legend' => 'input.creator.email', 'errorMsg' => 'input.creator.empty.email', 'errorLevel' => ErrorType::WARN];
    const CREATOR_ORCID = ['legend' => 'input.creator.orcid', 'errorMsg' => 'input.creator.empty.orcid', 'errorLevel' => ErrorType::INFO];
    const CREATOR_AFFILIATION = ['legend' => 'input.creator.affiliation', 'errorMsg' => 'input.creator.empty.affiliation', 'errorLevel' => ErrorType::ERROR];
    const CREATOR_ROLES = ['legend' => 'input.creator.roles', 'errorMsg' => 'input.creator.empty.roles', 'errorLevel' => ErrorType::ERROR];
    /*THEORY*/
    const OBJECTIVES = ['legend' => 'input.objective.legend', 'errorMsg' => 'input.objectives.empty', 'errorLevel' => ErrorType::WARN];
    const HYPOTHESIS = ['legend' => 'input.hypothesis.legend', 'errorMsg' => 'input.hypotheses.empty', 'errorLevel' => ErrorType::WARN];
    /*METHOD*/
    const DESIGN = ['legend' => 'input.design.legend', 'errorMsg' => 'input.design.empty', 'errorLevel' => ErrorType::ERROR];
    const EXPERIMENTAL = ['legend' => 'input.design.details.legend', 'errorMsg' => 'input.design.details.empty', 'errorLevel' => ErrorType::ERROR];
    const NON_EXPERIMENTAL = ['legend' => 'input.design.details.legend', 'errorMsg' => 'input.design.details.empty', 'errorLevel' => ErrorType::ERROR];
    const OBSERVABLE_TYPE = ['legend' => 'input.design.details.observationalType.legend', 'errorMsg' => 'input.design.details.observationalType.empty', 'errorLevel' => ErrorType::ERROR];
    const SETTING = ['legend' => 'input.setting.legend', 'errorMsg' => 'input.setting.empty', 'errorLevel' => ErrorType::ERROR];
    const SETTING_LOCATION = ['legend' => 'input.setting.location.legend', 'errorMsg' => 'input.setting.location.empty', 'errorLevel' => ErrorType::ERROR];
    const MANIPULATIONS = ['legend' => 'input.manipulations.legend', 'errorMsg' => 'input.manipulations.empty', 'errorLevel' => ErrorType::WARN];
    const EXPERIMENTAL_DESIGN = ['legend' => 'input.experimental-design.legend', 'errorMsg' => 'input.experimental-design.empty', 'errorLevel' => ErrorType::WARN];
    const CONTROL_OPS = ['legend' => 'input.control-operations.legend', 'errorMsg' => 'input.control-operations.empty', 'errorLevel' => ErrorType::WARN];
    /*MEASURE*/
    const MEASURES = ['legend' => 'input.measures.legend', 'errorMsg' => 'input.measures.empty', 'errorLevel' => ErrorType::ERROR];
    const APPARATUS = ['legend' => 'input.apparatus.legend', 'errorMsg' => 'input.apparatus.empty', 'errorLevel' => ErrorType::ERROR];
    /*SAMPLE*/
    const PARTICIPANTS = ['legend' => 'input.participants.legend', 'errorMsg' => 'input.participants.empty', 'errorLevel' => ErrorType::ERROR];
    const POPULATION = ['legend' => 'input.population.legend', 'errorMsg' => 'input.population.empty', 'errorLevel' => ErrorType::ERROR];
    const INCLUSION = ['legend' => 'input.inclusion.legend', 'errorMsg' => 'input.inclusion.empty', 'errorLevel' => ErrorType::ERROR];
    const EXCLUSION = ['legend' => 'input.exclusion.legend', 'errorMsg' => 'input.exclusion.empty', 'errorLevel' => ErrorType::ERROR];
    const SAMPLING = ['legend' => 'input.sampling.legend', 'errorMsg' => 'input.sampling.empty', 'errorLevel' => ErrorType::ERROR];
    const SAMPLE_SIZE = ['legend' => 'input.sample-size.legend', 'errorMsg' => 'input.sample-size.empty', 'errorLevel' => ErrorType::ERROR];
    const POWER_ANALYSIS = ['legend' => 'input.power-analysis.legend', 'errorMsg' => 'input.power-analysis.empty', 'errorLevel' => ErrorType::ERROR];
}