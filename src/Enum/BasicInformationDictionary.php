<?php

namespace App\Enum;

enum BasicInformationDictionary: string implements DictionaryInterface
{
    use ExtendedEnum;
    use DictionaryEnum;

    case TITLE = 'title';
    case TITLE_TRANSLATED = 'titleTranslated';
    case STUDY_ID = 'studyId';
    case DESCRIPTION = 'description';
    case DESCRIPTION_TRANSLATED = 'descriptionTranslated';
    case DATA_STATUS = 'dataStatus';
    case REUSE_POTENTIAL = 'reusePotentialOfDataSubset';
    case STUDY_RELATION = 'studyRelation';
    case STUDY_RELATION_OTHER_DESCRIPTION = 'studyRelationOtherDescription';
    case USED_SOFTWARES = 'usedSoftwares';
    case RELATED_PUBLICATIONS = 'relatedPublications';
    case CONFLICTS_OF_INTEREST = 'conflictsOfInterest';
    case CREATORS = 'creators';

    public function legend(): string
    {
        return match ($this) {
            self::TITLE => 'basic_information_meta_data_group.title.legend',
            self::TITLE_TRANSLATED => 'basic_information_meta_data_group.title_translated.legend',
            self::STUDY_ID => 'basic_information_meta_data_group.study_id.legend',
            self::DESCRIPTION => 'basic_information_meta_data_group.description.legend',
            self::DESCRIPTION_TRANSLATED => 'basic_information_meta_data_group.description_translated.legend',
            self::DATA_STATUS => 'basic_information_meta_data_group.data_status.legend',
            self::REUSE_POTENTIAL => 'basic_information_meta_data_group.reuse_potential.legend',
            self::STUDY_RELATION => 'basic_information_meta_data_group.study_relation.legend',
            self::STUDY_RELATION_OTHER_DESCRIPTION => 'basic_information_meta_data_group.study_relation_other_description.legend',
            self::USED_SOFTWARES => 'basic_information_meta_data_group.used_softwares.legend',
            self::RELATED_PUBLICATIONS => 'basic_information_meta_data_group.related_publications.legend',
            self::CONFLICTS_OF_INTEREST => 'basic_information_meta_data_group.conflicts_of_interest.legend',
            self::CREATORS => 'basic_information_meta_data_group.creators.legend',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::TITLE => 'basic_information_meta_data_group.title.label',
            self::TITLE_TRANSLATED => 'basic_information_meta_data_group.title_translated.label',
            self::STUDY_ID => 'basic_information_meta_data_group.study_id.label',
            self::DESCRIPTION => 'basic_information_meta_data_group.description.label',
            self::DESCRIPTION_TRANSLATED => 'basic_information_meta_data_group.description_translated.label',
            self::DATA_STATUS => 'basic_information_meta_data_group.data_status.label',
            self::REUSE_POTENTIAL => 'basic_information_meta_data_group.reuse_potential.label',
            self::STUDY_RELATION => 'basic_information_meta_data_group.study_relation.label',
            self::STUDY_RELATION_OTHER_DESCRIPTION => 'basic_information_meta_data_group.study_relation_other_description.label',
            self::USED_SOFTWARES => 'basic_information_meta_data_group.used_softwares.label',
            self::RELATED_PUBLICATIONS => 'basic_information_meta_data_group.related_publications.label',
            self::CONFLICTS_OF_INTEREST => 'basic_information_meta_data_group.conflicts_of_interest.label',
            self::CREATORS => 'basic_information_meta_data_group.creators.label',
        };
    }

    public function help(): ?string
    {
        return match ($this) {
            self::USED_SOFTWARES => 'basic_information_meta_data_group.used_softwares.help',
            self::RELATED_PUBLICATIONS => 'basic_information_meta_data_group.related_publications.help',
            self::CONFLICTS_OF_INTEREST => 'basic_information_meta_data_group.conflicts_of_interest.help',
            default => null,
        };
    }

    public function descriptionHelp(): ?string
    {
        return match ($this) {
            self::TITLE => 'basic.title',
            self::TITLE_TRANSLATED => 'basic.title_translated',
            self::DESCRIPTION => 'basic.description',
            self::DESCRIPTION_TRANSLATED => 'basic.description_translated',
            self::DATA_STATUS => 'basic.data_status',
            self::REUSE_POTENTIAL => 'basic.reuse_potential',
            self::USED_SOFTWARES => 'basic.used_softwares',
            self::RELATED_PUBLICATIONS => 'basic.related_publications',
            self::CONFLICTS_OF_INTEREST => 'basic.conflicts_of_interest',
            self::CREATORS => 'basic.creators',
            default => null,
        };
    }
}
