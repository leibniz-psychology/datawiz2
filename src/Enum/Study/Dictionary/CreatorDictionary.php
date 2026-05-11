<?php

namespace App\Enum\Study\Dictionary;

use App\Entity\Dto\ReviewDataDto;
use App\Enum\DictionaryEnum;
use App\Enum\DictionaryInterface;
use App\Enum\ErrorType;
use App\Enum\ExtendedEnum;

enum CreatorDictionary: string implements DictionaryInterface
{
    use ExtendedEnum;
    use DictionaryEnum;

    case GIVEN_NAME = 'givenName';
    case FAMILY_NAME = 'familyName';
    case EMAIL = 'email';
    case ORCID = 'orcid';
    case AFFILIATION = 'affiliation';
    case RESPONSIBILITIES = 'responsibilities';
    case RESPONSIBILITIES_OTHER_DESCRIPTION = 'responsibilitiesOtherDescription';

    public function legend(): string
    {
        return match ($this) {
            self::GIVEN_NAME => 'creator_meta_data_group.given_name.label',
            self::FAMILY_NAME => 'creator_meta_data_group.family_name.label',
            self::EMAIL => 'creator_meta_data_group.email.label',
            self::ORCID => 'creator_meta_data_group.orcid.label',
            self::AFFILIATION => 'creator_meta_data_group.affiliation.label',
            self::RESPONSIBILITIES => 'creator_meta_data_group.responsibilities.label',
            self::RESPONSIBILITIES_OTHER_DESCRIPTION => 'creator_meta_data_group.responsibilities_other_description.label',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::GIVEN_NAME => 'creator_meta_data_group.given_name.label',
            self::FAMILY_NAME => 'creator_meta_data_group.family_name.label',
            self::EMAIL => 'creator_meta_data_group.email.label',
            self::ORCID => 'creator_meta_data_group.orcid.label',
            self::AFFILIATION => 'creator_meta_data_group.affiliation.label',
            self::RESPONSIBILITIES => 'creator_meta_data_group.responsibilities.label',
            self::RESPONSIBILITIES_OTHER_DESCRIPTION => 'creator_meta_data_group.responsibilities_other_description.label',
        };
    }

    public function reviewData(): ReviewDataDto
    {
        return match ($this) {
            self::GIVEN_NAME => new ReviewDataDto('creator_meta_data_group.given_name.error_message', ErrorType::MANDATORY),
            self::FAMILY_NAME => new ReviewDataDto('creator_meta_data_group.family_name.error_message', ErrorType::MANDATORY),
            self::EMAIL => new ReviewDataDto('creator_meta_data_group.email.error_message', ErrorType::RECOMMENDED),
            self::ORCID => new ReviewDataDto('creator_meta_data_group.orcid.error_message', ErrorType::OPTIONAL),
            self::AFFILIATION => new ReviewDataDto('creator_meta_data_group.affiliation.error_message', ErrorType::MANDATORY),
            self::RESPONSIBILITIES => new ReviewDataDto('creator_meta_data_group.responsibilities.error_message', ErrorType::MANDATORY),
            self::RESPONSIBILITIES_OTHER_DESCRIPTION => new ReviewDataDto('creator_meta_data_group.responsibilities_other_description.error_message', ErrorType::OPTIONAL),
        };
    }
}
