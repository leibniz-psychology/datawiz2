<?php

declare(strict_types=1);

namespace App\Enum\DataManagementPlan\Dictionary;

use App\Entity\Dto\ReviewDataDto;
use App\Enum\DictionaryEnum;
use App\Enum\DictionaryInterface;
use App\Enum\ErrorType;
use App\Enum\ExtendedEnum;

enum DmpDataSharingDictionary: string implements DictionaryInterface
{
    use ExtendedEnum;
    use DictionaryEnum;

    case SHARING_OBLIGATION = 'sharingObligation';
    case INTENDED_USE = 'intendedUse';
    case THIRD_PARTY_ACCESS = 'thirdPartyAccess';
    case REPOSITORY_NAME = 'repositoryName';
    case DATA_SEARCHABILITY = 'dataSearchability';
    case DEPOSIT_TIMEPOINT = 'depositTimepoint';
    case SENSITIVE_DATA_REQUIREMENTS = 'sensitiveDataRequirements';
    case INITIAL_USE_RIGHT = 'initialUseRight';
    case USAGE_RESTRICTION = 'usageRestriction';
    case ACCESS_COST = 'accessCost';
    case REPOSITORY_RESPONSIBILITIES_FIXATION = 'repositoryResponsibilitiesFixation';
    case ACQUISITION_AGREEMENT = 'acquisitionAgreement';
    case PERSISTENT_IDENTIFIER_USE = 'persistentIdentifierUse';
    case PERSISTENT_IDENTIFIER_USE_OTHER_DESCRIPTION = 'persistentIdentifierUseOtherDescription';
    case NO_REPOSITORY_EXPLANATION = 'noRepositoryExplanation';
    case NO_SHARING_EXPLANATION = 'noSharingExplanation';
    case NO_SHARING_EXPLANATION_OTHER_DESCRIPTION = 'noSharingExplanationOtherDescription';

    public function legend(): string
    {
        return match ($this) {
            self::SHARING_OBLIGATION => 'data_management_plan.data_sharing.sharing_obligation.legend',
            self::INTENDED_USE => 'data_management_plan.data_sharing.intended_use.legend',
            self::THIRD_PARTY_ACCESS => 'data_management_plan.data_sharing.third_party_access.legend',
            self::REPOSITORY_NAME => 'data_management_plan.data_sharing.repository_name.legend',
            self::DATA_SEARCHABILITY => 'data_management_plan.data_sharing.data_searchability.legend',
            self::DEPOSIT_TIMEPOINT => 'data_management_plan.data_sharing.deposit_timepoint.legend',
            self::SENSITIVE_DATA_REQUIREMENTS => 'data_management_plan.data_sharing.sensitive_data_requirements.legend',
            self::INITIAL_USE_RIGHT => 'data_management_plan.data_sharing.initial_use_right.legend',
            self::USAGE_RESTRICTION => 'data_management_plan.data_sharing.usage_restriction.legend',
            self::ACCESS_COST => 'data_management_plan.data_sharing.access_cost.legend',
            self::REPOSITORY_RESPONSIBILITIES_FIXATION => 'data_management_plan.data_sharing.repository_responsibilities_fixation.legend',
            self::ACQUISITION_AGREEMENT => 'data_management_plan.data_sharing.acquisition_agreement.legend',
            self::PERSISTENT_IDENTIFIER_USE => 'data_management_plan.data_sharing.persistent_identifier_use.legend',
            self::PERSISTENT_IDENTIFIER_USE_OTHER_DESCRIPTION => 'data_management_plan.data_sharing.persistent_identifier_use_other_description.legend',
            self::NO_REPOSITORY_EXPLANATION => 'data_management_plan.data_sharing.no_repository_explanation.legend',
            self::NO_SHARING_EXPLANATION => 'data_management_plan.data_sharing.no_sharing_explanation.legend',
            self::NO_SHARING_EXPLANATION_OTHER_DESCRIPTION => 'data_management_plan.data_sharing.no_sharing_explanation_other_description.legend',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::SHARING_OBLIGATION => 'data_management_plan.data_sharing.sharing_obligation.label',
            self::INTENDED_USE => 'data_management_plan.data_sharing.intended_use.label',
            self::THIRD_PARTY_ACCESS => 'data_management_plan.data_sharing.third_party_access.label',
            self::REPOSITORY_NAME => 'data_management_plan.data_sharing.repository_name.label',
            self::DATA_SEARCHABILITY => 'data_management_plan.data_sharing.data_searchability.label',
            self::DEPOSIT_TIMEPOINT => 'data_management_plan.data_sharing.deposit_timepoint.label',
            self::SENSITIVE_DATA_REQUIREMENTS => 'data_management_plan.data_sharing.sensitive_data_requirements.label',
            self::INITIAL_USE_RIGHT => 'data_management_plan.data_sharing.initial_use_right.label',
            self::USAGE_RESTRICTION => 'data_management_plan.data_sharing.usage_restriction.label',
            self::ACCESS_COST => 'data_management_plan.data_sharing.access_cost.label',
            self::REPOSITORY_RESPONSIBILITIES_FIXATION => 'data_management_plan.data_sharing.repository_responsibilities_fixation.label',
            self::ACQUISITION_AGREEMENT => 'data_management_plan.data_sharing.acquisition_agreement.label',
            self::PERSISTENT_IDENTIFIER_USE => 'data_management_plan.data_sharing.persistent_identifier_use.label',
            self::PERSISTENT_IDENTIFIER_USE_OTHER_DESCRIPTION => 'data_management_plan.data_sharing.persistent_identifier_use_other_description.label',
            self::NO_REPOSITORY_EXPLANATION => 'data_management_plan.data_sharing.no_repository_explanation.label',
            self::NO_SHARING_EXPLANATION => 'data_management_plan.data_sharing.no_sharing_explanation.label',
            self::NO_SHARING_EXPLANATION_OTHER_DESCRIPTION => 'data_management_plan.data_sharing.no_sharing_explanation_other_description.label',
        };
    }

    public function placeholder(): ?string
    {
        return match ($this) {
            self::SHARING_OBLIGATION => 'data_management_plan.data_sharing.sharing_obligation.placeholder',
            self::THIRD_PARTY_ACCESS => 'data_management_plan.data_sharing.third_party_access.placeholder',
            self::ACCESS_COST => 'data_management_plan.data_sharing.access_cost.placeholder',
            self::REPOSITORY_RESPONSIBILITIES_FIXATION => 'data_management_plan.data_sharing.repository_responsibilities_fixation.placeholder',
            self::ACQUISITION_AGREEMENT => 'data_management_plan.data_sharing.acquisition_agreement.placeholder',
            self::PERSISTENT_IDENTIFIER_USE => 'data_management_plan.data_sharing.persistent_identifier_use.placeholder',
            self::NO_SHARING_EXPLANATION => 'data_management_plan.data_sharing.no_sharing_explanation.placeholder',
            default => null,
        };
    }

    public function help(): ?string
    {
        return match ($this) {
            self::SHARING_OBLIGATION => 'data_management_plan.data_sharing.sharing_obligation.help',
            self::REPOSITORY_NAME => 'data_management_plan.data_sharing.repository_name.help',
            self::DATA_SEARCHABILITY => 'data_management_plan.data_sharing.data_searchability.help',
            self::DEPOSIT_TIMEPOINT => 'data_management_plan.data_sharing.deposit_timepoint.help',
            self::SENSITIVE_DATA_REQUIREMENTS => 'data_management_plan.data_sharing.sensitive_data_requirements.help',
            default => null,
        };
    }

    public function descriptionHelp(): ?string
    {
        return match ($this) {
            self::INTENDED_USE => 'data_management_plan.data_sharing.intended_use',
            self::USAGE_RESTRICTION => 'data_management_plan.data_sharing.usage_restriction',
            self::REPOSITORY_RESPONSIBILITIES_FIXATION => 'data_management_plan.data_sharing.repository_responsibilities_fixation',
            self::ACQUISITION_AGREEMENT => 'data_management_plan.data_sharing.acquisition_agreement',
            self::PERSISTENT_IDENTIFIER_USE => 'data_management_plan.data_sharing.persistent_identifier_use',
            self::NO_SHARING_EXPLANATION => 'data_management_plan.data_sharing.no_sharing_explanation',
            default => null,
        };
    }

    public function reviewData(): ReviewDataDto
    {
        return match ($this) {
            self::SHARING_OBLIGATION => new ReviewDataDto('data_management_plan.data_sharing.sharing_obligation.error_message', ErrorType::RECOMMENDED),
            self::INTENDED_USE => new ReviewDataDto('data_management_plan.data_sharing.intended_use.error_message', ErrorType::RECOMMENDED),
            self::THIRD_PARTY_ACCESS => new ReviewDataDto('data_management_plan.data_sharing.third_party_access.error_message', ErrorType::RECOMMENDED),
            self::REPOSITORY_NAME => new ReviewDataDto('data_management_plan.data_sharing.repository_name.error_message', ErrorType::RECOMMENDED),
            self::DATA_SEARCHABILITY => new ReviewDataDto('data_management_plan.data_sharing.data_searchability.error_message', ErrorType::RECOMMENDED),
            self::DEPOSIT_TIMEPOINT => new ReviewDataDto('data_management_plan.data_sharing.deposit_timepoint.error_message', ErrorType::RECOMMENDED),
            self::SENSITIVE_DATA_REQUIREMENTS => new ReviewDataDto('data_management_plan.data_sharing.sensitive_data_requirements.error_message', ErrorType::RECOMMENDED),
            self::INITIAL_USE_RIGHT => new ReviewDataDto('data_management_plan.data_sharing.initial_use_right.error_message', ErrorType::RECOMMENDED),
            self::USAGE_RESTRICTION => new ReviewDataDto('data_management_plan.data_sharing.usage_restriction.error_message', ErrorType::RECOMMENDED),
            self::ACCESS_COST => new ReviewDataDto('data_management_plan.data_sharing.access_cost.error_message', ErrorType::RECOMMENDED),
            self::REPOSITORY_RESPONSIBILITIES_FIXATION => new ReviewDataDto('data_management_plan.data_sharing.repository_responsibilities_fixation.error_message', ErrorType::RECOMMENDED),
            self::ACQUISITION_AGREEMENT => new ReviewDataDto('data_management_plan.data_sharing.acquisition_agreement.error_message', ErrorType::RECOMMENDED),
            self::PERSISTENT_IDENTIFIER_USE => new ReviewDataDto('data_management_plan.data_sharing.persistent_identifier_use.error_message', ErrorType::RECOMMENDED),
            self::PERSISTENT_IDENTIFIER_USE_OTHER_DESCRIPTION => new ReviewDataDto('data_management_plan.data_sharing.persistent_identifier_use_other_description.error_message', ErrorType::RECOMMENDED),
            self::NO_REPOSITORY_EXPLANATION => new ReviewDataDto('data_management_plan.data_sharing.no_repository_explanation.error_message', ErrorType::RECOMMENDED),
            self::NO_SHARING_EXPLANATION => new ReviewDataDto('data_management_plan.data_sharing.no_sharing_explanation.error_message', ErrorType::RECOMMENDED),
            self::NO_SHARING_EXPLANATION_OTHER_DESCRIPTION => new ReviewDataDto('data_management_plan.data_sharing.no_sharing_explanation_other_description.error_message', ErrorType::RECOMMENDED),
        };
    }
}
