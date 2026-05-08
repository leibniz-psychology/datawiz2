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
    case CREDIT_ROLES = 'creditRoles';

    public function legend(): string
    {
        return match ($this) {
            self::GIVEN_NAME => 'creator_meta_data_group.given_name.label',
            self::FAMILY_NAME => 'creator_meta_data_group.family_name.label',
            self::EMAIL => 'creator_meta_data_group.email.label',
            self::ORCID => 'creator_meta_data_group.orcid.label',
            self::AFFILIATION => 'creator_meta_data_group.affiliation.label',
            self::CREDIT_ROLES => 'creator_meta_data_group.credit_roles.label',
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
            self::CREDIT_ROLES => 'creator_meta_data_group.credit_roles.label',
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
            self::CREDIT_ROLES => new ReviewDataDto('creator_meta_data_group.credit_roles.error_message', ErrorType::MANDATORY),
        };
    }
}
