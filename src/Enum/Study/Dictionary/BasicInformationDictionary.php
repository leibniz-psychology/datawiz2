<?php

namespace App\Enum\Study\Dictionary;

use App\Entity\Dto\ReviewDataDto;
use App\Enum\DictionaryEnum;
use App\Enum\DictionaryInterface;
use App\Enum\ErrorType;
use App\Enum\ExtendedEnum;

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

    public function reviewData(): ReviewDataDto
    {
        return match ($this) {
            self::TITLE => new ReviewDataDto('basic_information_meta_data_group.title.error_message', ErrorType::MANDATORY),
            self::TITLE_TRANSLATED => new ReviewDataDto('basic_information_meta_data_group.title_translated.error_message', ErrorType::RECOMMENDED),
            self::STUDY_ID => new ReviewDataDto('basic_information_meta_data_group.study_id.error_message', ErrorType::OPTIONAL),
            self::DESCRIPTION => new ReviewDataDto('basic_information_meta_data_group.description.error_message', ErrorType::MANDATORY),
            self::DESCRIPTION_TRANSLATED => new ReviewDataDto('basic_information_meta_data_group.description_translated.error_message', ErrorType::RECOMMENDED),
            self::DATA_STATUS => new ReviewDataDto('basic_information_meta_data_group.data_status.error_message', ErrorType::RECOMMENDED),
            self::REUSE_POTENTIAL => new ReviewDataDto('basic_information_meta_data_group.reuse_potential.error_message', ErrorType::RECOMMENDED),
            self::STUDY_RELATION => new ReviewDataDto('basic_information_meta_data_group.study_relation.error_message', ErrorType::OPTIONAL),
            self::STUDY_RELATION_OTHER_DESCRIPTION => new ReviewDataDto('basic_information_meta_data_group.study_relation_other_description.error_message', ErrorType::OPTIONAL),
            self::USED_SOFTWARES => new ReviewDataDto('basic_information_meta_data_group.used_softwares.error_message', ErrorType::OPTIONAL),
            self::RELATED_PUBLICATIONS => new ReviewDataDto('basic_information_meta_data_group.related_publications.error_message', ErrorType::OPTIONAL),
            self::CONFLICTS_OF_INTEREST => new ReviewDataDto('basic_information_meta_data_group.conflicts_of_interest.error_message', ErrorType::MANDATORY),
            self::CREATORS => new ReviewDataDto('basic_information_meta_data_group.creators.error_message', ErrorType::MANDATORY),
        };
    }
}
