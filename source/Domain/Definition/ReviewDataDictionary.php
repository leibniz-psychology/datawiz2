<?php

namespace App\Domain\Definition;

class ReviewDataDictionary
{
    /* BASIC */
    const TITLE = ['legend' => 'input.title.legend', 'errorMsg' => 'input.title.empty', 'errorLevel' => ErrorType::MANDATORY];
    const DESCRIPTION = ['legend' => 'input.description.legend', 'errorMsg' => 'input.description.empty', 'errorLevel' => ErrorType::MANDATORY];
    const RELATED_PUBS = ['legend' => 'input.relatedPubs.legend', 'errorMsg' => 'input.relatedPubs.empty', 'errorLevel' => ErrorType::OPTIONAL];
    /*CREATOR*/
    const CREATOR_GIVEN = ['legend' => 'input.creator.name.given', 'errorMsg' => 'input.creator.empty.given', 'errorLevel' => ErrorType::MANDATORY];
    const CREATOR_FAMILY = ['legend' => 'input.creator.name.family', 'errorMsg' => 'input.creator.empty.family', 'errorLevel' => ErrorType::MANDATORY];
    const CREATOR_EMAIL = ['legend' => 'input.creator.email', 'errorMsg' => 'input.creator.empty.email', 'errorLevel' => ErrorType::RECOMMENDED];
    const CREATOR_ORCID = ['legend' => 'input.creator.orcid', 'errorMsg' => 'input.creator.empty.orcid', 'errorLevel' => ErrorType::OPTIONAL];
    const CREATOR_AFFILIATION = ['legend' => 'input.creator.affiliation', 'errorMsg' => 'input.creator.empty.affiliation', 'errorLevel' => ErrorType::MANDATORY];
    const CREATOR_ROLES = ['legend' => 'input.creator.roles', 'errorMsg' => 'input.creator.empty.roles', 'errorLevel' => ErrorType::MANDATORY];
    /*THEORY*/
    const OBJECTIVES = ['legend' => 'input.objective.legend', 'errorMsg' => 'input.objective.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    const HYPOTHESIS = ['legend' => 'input.hypothesis.legend', 'errorMsg' => 'input.hypothesis.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    /*METHOD*/
    const DESIGN = ['legend' => 'input.design.legend', 'errorMsg' => 'input.design.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    const EXPERIMENTAL = ['legend' => 'input.design.details.legend', 'errorMsg' => 'input.design.details.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    const NON_EXPERIMENTAL = ['legend' => 'input.design.details.legend', 'errorMsg' => 'input.design.details.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    const OBSERVABLE_TYPE = ['legend' => 'input.design.details.observationalType.legend', 'errorMsg' => 'input.design.details.observationalType.empty', 'errorLevel' => ErrorType::MANDATORY];
    const SETTING = ['legend' => 'input.setting.legend', 'errorMsg' => 'input.setting.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    const SETTING_LOCATION = ['legend' => 'input.setting.location.legend', 'errorMsg' => 'input.setting.location.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    const MANIPULATIONS = ['legend' => 'input.manipulations.legend', 'errorMsg' => 'input.manipulations.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    const EXPERIMENTAL_DESIGN = ['legend' => 'input.experimental-design.legend', 'errorMsg' => 'input.experimental-design.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    const CONTROL_OPS = ['legend' => 'input.control-operations.legend', 'errorMsg' => 'input.control-operations.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    /*MEASURE*/
    const MEASURES = ['legend' => 'input.measures.legend', 'errorMsg' => 'input.measures.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    const APPARATUS = ['legend' => 'input.apparatus.legend', 'errorMsg' => 'input.apparatus.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    /*SAMPLE*/
    const PARTICIPANTS = ['legend' => 'input.participants.legend', 'errorMsg' => 'input.participants.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    const POPULATION = ['legend' => 'input.population.legend', 'errorMsg' => 'input.population.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    const INCLUSION = ['legend' => 'input.inclusion.legend', 'errorMsg' => 'input.inclusion.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    const EXCLUSION = ['legend' => 'input.exclusion.legend', 'errorMsg' => 'input.exclusion.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    const SAMPLING = ['legend' => 'input.sampling.legend', 'errorMsg' => 'input.sampling.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    const SAMPLE_SIZE = ['legend' => 'input.sample-size.legend', 'errorMsg' => 'input.sample-size.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    const POWER_ANALYSIS = ['legend' => 'input.power-analysis.legend', 'errorMsg' => 'input.power-analysis.empty', 'errorLevel' => ErrorType::RECOMMENDED];
}
