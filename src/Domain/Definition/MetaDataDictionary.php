<?php

namespace App\Domain\Definition;

final class MetaDataDictionary
{
    // SettingsMetaData
    const SHORTNAME = 'shortName';

    // BasicInformationMetaData
    const TITLE = 'title';
    const CREATORS = 'creators';
    const CONTACT = 'contact';
    const DESCRIPTION = 'description';
    const RELATED_PUBS = 'related_publications';

    // SampleMetaData
    const INCLUSION_CRITERIA = 'inclusion_criteria';
    const EXCLUSION_CRITERIA = 'exclusion_criteria';
    const POPULATION = 'population';
    const SAMPLING_METHOD = 'sampling_method';
    const SAMPLE_SIZE = 'sample_size';
    const POWER_ANALYSIS = 'power_analysis';

    // TheoryMetaData
    const OBJECTIVE = 'objective';
    const HYPOTHESIS = 'hypothesis';

    // MeasureMetaData
    const MEASURES = 'measures';
    const APPARATUS = 'apparatus';

    // MethodMetaData
    const SETTING = 'setting';
    const RESEARCH_DESIGN = 'research_design';
    const MANIPULATIONS = 'manipulations';
    const ASSIGNMENT = 'assignment';
    const EXPERIMENTAL_DESIGN = 'experimental_design';
    const CONTROL_OPERATIONS = 'control_operations';

    // Filemanagement
    const FILE_DESCRIPTION = 'file_description';
}
