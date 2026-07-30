<?php

declare(strict_types=1);

namespace App\Enum\DataManagementPlan\Dictionary;

use App\Entity\Dto\ReviewDataDto;
use App\Enum\DictionaryEnum;
use App\Enum\DictionaryInterface;
use App\Enum\ErrorType;
use App\Enum\ExtendedEnum;

enum DmpEthicalLegalDictionary: string implements DictionaryInterface
{
    use ExtendedEnum;
    use DictionaryEnum;

    case ETHICAL_REVIEW = 'ethicalReview';
    case INFORMED_CONSENT = 'informedConsent';
    case INFORMED_CONSENT_DATA_SHARING = 'informedConsentDataSharing';
    case NO_INFORMED_CONSENT_REASON = 'noInformedConsentReason';
    case PERSONAL_DATA = 'personalData';
    case PERSONAL_DATA_PROTECTION_MEASURES = 'personalDataProtectionMeasures';
    case COMMERCIAL_SENSITIVE_DATA = 'commercialSensitiveData';
    case COMMERCIAL_DATA_PROTECTION_MEASURES = 'commercialDataProtectionMeasures';
    case COPYRIGHT = 'copyright';
    case COPYRIGHT_LICENSES = 'copyrightLicenses';
    case THIRD_PARTY_RIGHTS = 'thirdPartyRights';
    case THIRD_PARTY_LICENSES = 'thirdPartyLicenses';

    public function legend(): string
    {
        return match ($this) {
            self::ETHICAL_REVIEW => 'data_management_plan.ethical_legal.ethical_review.legend',
            self::INFORMED_CONSENT => 'data_management_plan.ethical_legal.informed_consent.legend',
            self::INFORMED_CONSENT_DATA_SHARING => 'data_management_plan.ethical_legal.informed_consent_data_sharing.legend',
            self::NO_INFORMED_CONSENT_REASON => 'data_management_plan.ethical_legal.no_informed_consent_reason.legend',
            self::PERSONAL_DATA => 'data_management_plan.ethical_legal.personal_data.legend',
            self::PERSONAL_DATA_PROTECTION_MEASURES => 'data_management_plan.ethical_legal.personal_data_protection_measures.legend',
            self::COMMERCIAL_SENSITIVE_DATA => 'data_management_plan.ethical_legal.commercial_sensitive_data.legend',
            self::COMMERCIAL_DATA_PROTECTION_MEASURES => 'data_management_plan.ethical_legal.commercial_data_protection_measures.legend',
            self::COPYRIGHT => 'data_management_plan.ethical_legal.copyright.legend',
            self::COPYRIGHT_LICENSES => 'data_management_plan.ethical_legal.copyright_licenses.legend',
            self::THIRD_PARTY_RIGHTS => 'data_management_plan.ethical_legal.third_party_rights.legend',
            self::THIRD_PARTY_LICENSES => 'data_management_plan.ethical_legal.third_party_licenses.legend',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::ETHICAL_REVIEW => 'data_management_plan.ethical_legal.ethical_review.label',
            self::INFORMED_CONSENT => 'data_management_plan.ethical_legal.informed_consent.label',
            self::INFORMED_CONSENT_DATA_SHARING => 'data_management_plan.ethical_legal.informed_consent_data_sharing.label',
            self::NO_INFORMED_CONSENT_REASON => 'data_management_plan.ethical_legal.no_informed_consent_reason.label',
            self::PERSONAL_DATA => 'data_management_plan.ethical_legal.personal_data.label',
            self::PERSONAL_DATA_PROTECTION_MEASURES => 'data_management_plan.ethical_legal.personal_data_protection_measures.label',
            self::COMMERCIAL_SENSITIVE_DATA => 'data_management_plan.ethical_legal.commercial_sensitive_data.label',
            self::COMMERCIAL_DATA_PROTECTION_MEASURES => 'data_management_plan.ethical_legal.commercial_data_protection_measures.label',
            self::COPYRIGHT => 'data_management_plan.ethical_legal.copyright.label',
            self::COPYRIGHT_LICENSES => 'data_management_plan.ethical_legal.copyright_licenses.label',
            self::THIRD_PARTY_RIGHTS => 'data_management_plan.ethical_legal.third_party_rights.label',
            self::THIRD_PARTY_LICENSES => 'data_management_plan.ethical_legal.third_party_licenses.label',
        };
    }

    public function placeholder(): ?string
    {
        return match ($this) {
            self::INFORMED_CONSENT => 'data_management_plan.ethical_legal.informed_consent.placeholder',
            self::INFORMED_CONSENT_DATA_SHARING => 'data_management_plan.ethical_legal.informed_consent_data_sharing.placeholder',
            self::PERSONAL_DATA => 'data_management_plan.ethical_legal.personal_data.placeholder',
            self::COMMERCIAL_SENSITIVE_DATA => 'data_management_plan.ethical_legal.commercial_sensitive_data.placeholder',
            self::COPYRIGHT => 'data_management_plan.ethical_legal.copyright.placeholder',
            self::THIRD_PARTY_RIGHTS => 'data_management_plan.ethical_legal.third_party_rights.placeholder',
            default => null,
        };
    }

    public function help(): ?string
    {
        return match ($this) {
            self::INFORMED_CONSENT => 'data_management_plan.ethical_legal.informed_consent.help',
            self::INFORMED_CONSENT_DATA_SHARING => 'data_management_plan.ethical_legal.informed_consent_data_sharing.help',
            self::PERSONAL_DATA => 'data_management_plan.ethical_legal.personal_data.help',
            self::COPYRIGHT_LICENSES => 'data_management_plan.ethical_legal.copyright_licenses.help',
            self::THIRD_PARTY_LICENSES => 'data_management_plan.ethical_legal.third_party_licenses.help',
            default => null,
        };
    }

    public function descriptionHelp(): ?string
    {
        return match ($this) {
            self::ETHICAL_REVIEW => 'data_management_plan.ethical_legal.ethical_review',
            default => null,
        };
    }

    public function reviewData(): ReviewDataDto
    {
        return match ($this) {
            self::ETHICAL_REVIEW => new ReviewDataDto('data_management_plan.ethical_legal.ethical_review.error_message', ErrorType::RECOMMENDED),
            self::INFORMED_CONSENT => new ReviewDataDto('data_management_plan.ethical_legal.informed_consent.error_message', ErrorType::RECOMMENDED),
            self::INFORMED_CONSENT_DATA_SHARING => new ReviewDataDto('data_management_plan.ethical_legal.informed_consent_data_sharing.error_message', ErrorType::RECOMMENDED),
            self::NO_INFORMED_CONSENT_REASON => new ReviewDataDto('data_management_plan.ethical_legal.no_informed_consent_reason.error_message', ErrorType::RECOMMENDED),
            self::PERSONAL_DATA => new ReviewDataDto('data_management_plan.ethical_legal.personal_data.error_message', ErrorType::RECOMMENDED),
            self::PERSONAL_DATA_PROTECTION_MEASURES => new ReviewDataDto('data_management_plan.ethical_legal.personal_data_protection_measures.error_message', ErrorType::RECOMMENDED),
            self::COMMERCIAL_SENSITIVE_DATA => new ReviewDataDto('data_management_plan.ethical_legal.commercial_sensitive_data.error_message', ErrorType::RECOMMENDED),
            self::COMMERCIAL_DATA_PROTECTION_MEASURES => new ReviewDataDto('data_management_plan.ethical_legal.commercial_data_protection_measures.error_message', ErrorType::RECOMMENDED),
            self::COPYRIGHT => new ReviewDataDto('data_management_plan.ethical_legal.copyright.error_message', ErrorType::RECOMMENDED),
            self::COPYRIGHT_LICENSES => new ReviewDataDto('data_management_plan.ethical_legal.copyright_licenses.error_message', ErrorType::RECOMMENDED),
            self::THIRD_PARTY_RIGHTS => new ReviewDataDto('data_management_plan.ethical_legal.third_party_rights.error_message', ErrorType::RECOMMENDED),
            self::THIRD_PARTY_LICENSES => new ReviewDataDto('data_management_plan.ethical_legal.third_party_licenses.error_message', ErrorType::RECOMMENDED),
        };
    }
}
