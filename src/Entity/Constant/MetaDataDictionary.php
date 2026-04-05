<?php

namespace App\Entity\Constant;

final class MetaDataDictionary
{
    // SettingsMetaData
    public const string SHORTNAME = 'shortName';

    // BasicInformationMetaData
    public const string TITLE = 'title';
    public const string CREATORS = 'creators';
    public const string CONTACT = 'contact';
    public const string DESCRIPTION = 'description';
    public const string RELATED_PUBS = 'related_publications';

    // SampleMetaData
    public const string INCLUSION_CRITERIA = 'inclusion_criteria';
    public const string EXCLUSION_CRITERIA = 'exclusion_criteria';
    public const string POPULATION = 'population';
    public const string SAMPLING_METHOD = 'sampling_method';
    public const string SAMPLE_SIZE = 'sample_size';
    public const string POWER_ANALYSIS = 'power_analysis';

    // TheoryMetaData
    public const string OBJECTIVE = 'objective';
    public const string HYPOTHESIS = 'hypothesis';

    // MeasureMetaData
    public const string MEASURES = 'measures';
    public const string APPARATUS = 'apparatus';

    // MethodMetaData
    public const string SETTING = 'setting';
    public const string RESEARCH_DESIGN = 'research_design';
    public const string MANIPULATIONS = 'manipulations';
    public const string ASSIGNMENT = 'assignment';
    public const string EXPERIMENTAL_DESIGN = 'experimental_design';
    public const string CONTROL_OPERATIONS = 'control_operations';

    // Filemanagement
    public const string FILE_DESCRIPTION = 'file_description';
}
