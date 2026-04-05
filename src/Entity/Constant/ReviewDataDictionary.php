<?php

namespace App\Entity\Constant;

class ReviewDataDictionary
{
    // BASIC
    final public const array TITLE = ['legend' => 'input.title.legend', 'errorMsg' => 'input.title.empty', 'errorLevel' => ErrorType::MANDATORY];
    final public const array DESCRIPTION = ['legend' => 'input.description.legend', 'errorMsg' => 'input.description.empty', 'errorLevel' => ErrorType::MANDATORY];
    final public const array RELATED_PUBS = ['legend' => 'input.relatedPubs.legend', 'errorMsg' => 'input.relatedPubs.empty', 'errorLevel' => ErrorType::OPTIONAL];
    // CREATOR
    final public const array CREATOR_GIVEN = ['legend' => 'input.creator.name.given', 'errorMsg' => 'input.creator.empty.given', 'errorLevel' => ErrorType::MANDATORY];
    final public const array CREATOR_FAMILY = ['legend' => 'input.creator.name.family', 'errorMsg' => 'input.creator.empty.family', 'errorLevel' => ErrorType::MANDATORY];
    final public const array CREATOR_EMAIL = ['legend' => 'input.creator.email', 'errorMsg' => 'input.creator.empty.email', 'errorLevel' => ErrorType::RECOMMENDED];
    final public const array CREATOR_ORCID = ['legend' => 'input.creator.orcid', 'errorMsg' => 'input.creator.empty.orcid', 'errorLevel' => ErrorType::OPTIONAL];
    final public const array CREATOR_AFFILIATION = ['legend' => 'input.creator.affiliation', 'errorMsg' => 'input.creator.empty.affiliation', 'errorLevel' => ErrorType::MANDATORY];
    final public const array CREATOR_ROLES = ['legend' => 'input.creator.roles', 'errorMsg' => 'error.roles.empty', 'errorLevel' => ErrorType::MANDATORY];
    // THEORY
    final public const array OBJECTIVES = ['legend' => 'input.objective.legend', 'errorMsg' => 'input.objective.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    final public const array HYPOTHESIS = ['legend' => 'input.hypothesis.legend', 'errorMsg' => 'input.hypothesis.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    // METHOD
    final public const array DESIGN = ['legend' => 'input.design.legend', 'errorMsg' => 'input.design.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    final public const array EXPERIMENTAL = ['legend' => 'input.design.details.legend', 'errorMsg' => 'input.design.details.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    final public const array NON_EXPERIMENTAL = ['legend' => 'input.design.details.legend', 'errorMsg' => 'input.design.details.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    final public const array OBSERVABLE_TYPE = ['legend' => 'input.design.details.observationalType.legend', 'errorMsg' => 'input.design.details.observationalType.empty', 'errorLevel' => ErrorType::MANDATORY];
    final public const array SETTING = ['legend' => 'input.setting.legend', 'errorMsg' => 'input.setting.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    final public const array SETTING_LOCATION = ['legend' => 'input.setting.location.legend', 'errorMsg' => 'input.setting.location.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    final public const array MANIPULATIONS = ['legend' => 'input.manipulations.legend', 'errorMsg' => 'input.manipulations.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    final public const array EXPERIMENTAL_DESIGN = ['legend' => 'input.experimental-design.legend', 'errorMsg' => 'input.experimental-design.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    final public const array CONTROL_OPS = ['legend' => 'input.control-operations.legend', 'errorMsg' => 'input.control-operations.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    // MEASURE
    final public const array MEASURES = ['legend' => 'input.measures.legend', 'errorMsg' => 'input.measures.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    final public const array APPARATUS = ['legend' => 'input.apparatus.legend', 'errorMsg' => 'input.apparatus.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    // SAMPLE
    final public const array PARTICIPANTS = ['legend' => 'input.participants.legend', 'errorMsg' => 'input.participants.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    final public const array POPULATION = ['legend' => 'input.population.legend', 'errorMsg' => 'input.population.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    final public const array INCLUSION = ['legend' => 'input.inclusion.legend', 'errorMsg' => 'input.inclusion.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    final public const array EXCLUSION = ['legend' => 'input.exclusion.legend', 'errorMsg' => 'input.exclusion.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    final public const array SAMPLING = ['legend' => 'input.sampling.legend', 'errorMsg' => 'input.sampling.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    final public const array SAMPLE_SIZE = ['legend' => 'input.sample-size.legend', 'errorMsg' => 'input.sample-size.empty', 'errorLevel' => ErrorType::RECOMMENDED];
    final public const array POWER_ANALYSIS = ['legend' => 'input.power-analysis.legend', 'errorMsg' => 'input.power-analysis.empty', 'errorLevel' => ErrorType::RECOMMENDED];
}
