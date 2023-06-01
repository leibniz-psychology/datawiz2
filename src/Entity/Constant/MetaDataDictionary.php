<?php

namespace App\Entity\Constant;

final class MetaDataDictionary
{
    // SettingsMetaData
    public const SHORTNAME = 'shortName';

    // BasicInformationMetaData
    public const TITLE = 'title';
    public const CREATORS = 'creators';
    public const CONTACT = 'contact';
    public const DESCRIPTION = 'description';
    public const RELATED_PUBS = 'related_publications';

    // SampleMetaData
    public const INCLUSION_CRITERIA = 'inclusion_criteria';
    public const EXCLUSION_CRITERIA = 'exclusion_criteria';
    public const POPULATION = 'population';
    public const SAMPLING_METHOD = 'sampling_method';
    public const SAMPLE_SIZE = 'sample_size';
    public const POWER_ANALYSIS = 'power_analysis';

    // TheoryMetaData
    public const OBJECTIVE = 'objective';
    public const HYPOTHESIS = 'hypothesis';

    // MeasureMetaData
    public const MEASURES = 'measures';
    public const APPARATUS = 'apparatus';

    // MethodMetaData
    public const SETTING = 'setting';
    public const RESEARCH_DESIGN = 'research_design';
    public const MANIPULATIONS = 'manipulations';
    public const ASSIGNMENT = 'assignment';
    public const EXPERIMENTAL_DESIGN = 'experimental_design';
    public const CONTROL_OPERATIONS = 'control_operations';

    // Filemanagement
    public const FILE_DESCRIPTION = 'file_description';
}
