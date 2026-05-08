<?php

namespace App\Enum\Study\Dictionary;

use App\Entity\Dto\ReviewDataDto;
use App\Enum\DictionaryEnum;
use App\Enum\DictionaryInterface;
use App\Enum\ErrorType;
use App\Enum\ExtendedEnum;

enum EthicsDictionary: string implements DictionaryInterface
{
    use ExtendedEnum;
    use DictionaryEnum;

    case ETHICAL_REVIEW = 'ethicalReview';
    case INFORMED_CONSENT = 'informedConsent';
    case PERSONAL_DATA = 'personalData';
    case COPYRIGHT = 'copyright';
    case THIRD_PARTY_RIGHTS = 'thirdPartyRights';

    public function legend(): string
    {
        return match ($this) {
            self::ETHICAL_REVIEW => 'ethics_meta_data_group.ethical_review.legend',
            self::INFORMED_CONSENT => 'ethics_meta_data_group.informed_consent.legend',
            self::PERSONAL_DATA => 'ethics_meta_data_group.personal_data.legend',
            self::COPYRIGHT => 'ethics_meta_data_group.copyright.legend',
            self::THIRD_PARTY_RIGHTS => 'ethics_meta_data_group.third_party_rights.legend',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::ETHICAL_REVIEW => 'ethics_meta_data_group.ethical_review.label',
            self::INFORMED_CONSENT => 'ethics_meta_data_group.informed_consent.label',
            self::PERSONAL_DATA => 'ethics_meta_data_group.personal_data.label',
            self::COPYRIGHT => 'ethics_meta_data_group.copyright.label',
            self::THIRD_PARTY_RIGHTS => 'ethics_meta_data_group.third_party_rights.label',
        };
    }

    public function placeholder(): string
    {
        return match ($this) {
            self::ETHICAL_REVIEW => 'ethics_meta_data_group.ethical_review.placeholder',
            self::INFORMED_CONSENT => 'ethics_meta_data_group.informed_consent.placeholder',
            self::PERSONAL_DATA => 'ethics_meta_data_group.personal_data.placeholder',
            self::COPYRIGHT => 'ethics_meta_data_group.copyright.placeholder',
            self::THIRD_PARTY_RIGHTS => 'ethics_meta_data_group.third_party_rights.placeholder',
        };
    }

    public function descriptionHelp(): string
    {
        return match ($this) {
            self::ETHICAL_REVIEW => 'ethics.ethical_review',
            self::INFORMED_CONSENT => 'ethics.informed_consent',
            self::PERSONAL_DATA => 'ethics.personal_data',
            self::COPYRIGHT => 'ethics.copyright',
            self::THIRD_PARTY_RIGHTS => 'ethics.third_party_rights',
        };
    }

    public function reviewData(): ReviewDataDto
    {
        return match ($this) {
            self::ETHICAL_REVIEW => new ReviewDataDto('ethics_meta_data_group.ethical_review.error_message', ErrorType::RECOMMENDED),
            self::INFORMED_CONSENT => new ReviewDataDto('ethics_meta_data_group.informed_consent.error_message', ErrorType::RECOMMENDED),
            self::PERSONAL_DATA => new ReviewDataDto('ethics_meta_data_group.personal_data.error_message', ErrorType::RECOMMENDED),
            self::COPYRIGHT => new ReviewDataDto('ethics_meta_data_group.copyright.error_message', ErrorType::RECOMMENDED),
            self::THIRD_PARTY_RIGHTS => new ReviewDataDto('ethics_meta_data_group.third_party_rights.error_message', ErrorType::RECOMMENDED),
        };
    }
}
