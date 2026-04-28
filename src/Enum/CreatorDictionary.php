<?php

namespace App\Enum;

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
}
