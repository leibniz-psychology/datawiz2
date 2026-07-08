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
    case ETHICAL_REVIEW_DESCRIPTION = 'ethicalReviewDescription';
    case INFORMED_CONSENT = 'informedConsent';
    case DATA_SHARING = 'dataSharing';
    case DATA_SHARING_LEVEL = 'dataSharingLevel';
    case DATA_SHARING_INFRASTRUCTURE = 'dataSharingInfrastructure';
    case PERSONAL_DATA = 'personalData';
    case COPYRIGHT = 'copyright';
    case COPYRIGHT_LICENSES = 'copyrightLicenses';
    case THIRD_PARTY_RIGHTS = 'thirdPartyRights';
    case THIRD_PARTY_LICENSES = 'thirdPartyLicenses';

    public function legend(): string
    {
        return match ($this) {
            self::ETHICAL_REVIEW => 'ethics_meta_data_group.ethical_review.legend',
            self::ETHICAL_REVIEW_DESCRIPTION => 'ethics_meta_data_group.ethical_review_description.legend',
            self::INFORMED_CONSENT => 'ethics_meta_data_group.informed_consent.legend',
            self::DATA_SHARING => 'ethics_meta_data_group.data_sharing.legend',
            self::DATA_SHARING_LEVEL => 'ethics_meta_data_group.data_sharing_level.legend',
            self::DATA_SHARING_INFRASTRUCTURE => 'ethics_meta_data_group.data_sharing_infrastructure.legend',
            self::PERSONAL_DATA => 'ethics_meta_data_group.personal_data.legend',
            self::COPYRIGHT => 'ethics_meta_data_group.copyright.legend',
            self::COPYRIGHT_LICENSES => 'ethics_meta_data_group.copyright_licenses.legend',
            self::THIRD_PARTY_RIGHTS => 'ethics_meta_data_group.third_party_rights.legend',
            self::THIRD_PARTY_LICENSES => 'ethics_meta_data_group.third_party_licenses.legend',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::ETHICAL_REVIEW => 'ethics_meta_data_group.ethical_review.label',
            self::ETHICAL_REVIEW_DESCRIPTION => 'ethics_meta_data_group.ethical_review_description.label',
            self::INFORMED_CONSENT => 'ethics_meta_data_group.informed_consent.label',
            self::DATA_SHARING => 'ethics_meta_data_group.data_sharing.label',
            self::DATA_SHARING_LEVEL => 'ethics_meta_data_group.data_sharing_level.label',
            self::DATA_SHARING_INFRASTRUCTURE => 'ethics_meta_data_group.data_sharing_infrastructure.label',
            self::PERSONAL_DATA => 'ethics_meta_data_group.personal_data.label',
            self::COPYRIGHT => 'ethics_meta_data_group.copyright.label',
            self::COPYRIGHT_LICENSES => 'ethics_meta_data_group.copyright_licenses.label',
            self::THIRD_PARTY_RIGHTS => 'ethics_meta_data_group.third_party_rights.label',
            self::THIRD_PARTY_LICENSES => 'ethics_meta_data_group.third_party_licenses.label',
        };
    }

    public function placeholder(): ?string
    {
        return match ($this) {
            self::ETHICAL_REVIEW => 'ethics_meta_data_group.ethical_review.placeholder',
            self::INFORMED_CONSENT => 'ethics_meta_data_group.informed_consent.placeholder',
            self::DATA_SHARING => 'ethics_meta_data_group.data_sharing.placeholder',
            self::PERSONAL_DATA => 'ethics_meta_data_group.personal_data.placeholder',
            self::COPYRIGHT => 'ethics_meta_data_group.copyright.placeholder',
            self::THIRD_PARTY_RIGHTS => 'ethics_meta_data_group.third_party_rights.placeholder',
            default => null,
        };
    }

    public function help(): ?string
    {
        return match ($this) {
            self::ETHICAL_REVIEW_DESCRIPTION => 'ethics_meta_data_group.ethical_review_description.help',
            self::DATA_SHARING_INFRASTRUCTURE => 'ethics_meta_data_group.data_sharing_infrastructure.help',
            self::THIRD_PARTY_LICENSES => 'ethics_meta_data_group.third_party_licenses.help',
            default => null,
        };
    }

    public function descriptionHelp(): ?string
    {
        return match ($this) {
            self::ETHICAL_REVIEW => 'ethics.ethical_review',
            self::INFORMED_CONSENT => 'ethics.informed_consent',
            self::PERSONAL_DATA => 'ethics.personal_data',
            self::COPYRIGHT => 'ethics.copyright',
            self::THIRD_PARTY_RIGHTS => 'ethics.third_party_rights',
            default => null,
        };
    }

    public function reviewData(): ReviewDataDto
    {
        return match ($this) {
            self::ETHICAL_REVIEW => new ReviewDataDto('ethics_meta_data_group.ethical_review.error_message', ErrorType::RECOMMENDED),
            self::ETHICAL_REVIEW_DESCRIPTION => new ReviewDataDto('ethics_meta_data_group.ethical_review_description.error_message', ErrorType::OPTIONAL),
            self::INFORMED_CONSENT => new ReviewDataDto('ethics_meta_data_group.informed_consent.error_message', ErrorType::RECOMMENDED),
            self::DATA_SHARING => new ReviewDataDto('ethics_meta_data_group.data_sharing.error_message', ErrorType::RECOMMENDED),
            self::DATA_SHARING_LEVEL => new ReviewDataDto('ethics_meta_data_group.data_sharing_level.error_message', ErrorType::RECOMMENDED),
            self::DATA_SHARING_INFRASTRUCTURE => new ReviewDataDto('ethics_meta_data_group.data_sharing_infrastructure.error_message', ErrorType::RECOMMENDED),
            self::PERSONAL_DATA => new ReviewDataDto('ethics_meta_data_group.personal_data.error_message', ErrorType::RECOMMENDED),
            self::COPYRIGHT => new ReviewDataDto('ethics_meta_data_group.copyright.error_message', ErrorType::RECOMMENDED),
            self::COPYRIGHT_LICENSES => new ReviewDataDto('ethics_meta_data_group.copyright_licenses.error_message', ErrorType::RECOMMENDED),
            self::THIRD_PARTY_RIGHTS => new ReviewDataDto('ethics_meta_data_group.third_party_rights.error_message', ErrorType::RECOMMENDED),
            self::THIRD_PARTY_LICENSES => new ReviewDataDto('ethics_meta_data_group.third_party_licenses.error_message', ErrorType::RECOMMENDED),
        };
    }
}
