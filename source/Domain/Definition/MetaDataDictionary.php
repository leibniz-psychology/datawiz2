<?php

namespace App\Domain\Definition;

final class MetaDataDictionary
{
    // SettingsMetaData
    const SHORTNAME = 'short_name';

    // BasicInformationMetaData
    const TITLE = 'title';
    const CREATOR = 'creator';
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
}
