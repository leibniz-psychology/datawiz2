<?php

declare(strict_types=1);

namespace App\Enum\DataManagementPlan\Dictionary;

use App\Entity\Dto\ReviewDataDto;
use App\Enum\DictionaryEnum;
use App\Enum\DictionaryInterface;
use App\Enum\ErrorType;
use App\Enum\ExtendedEnum;

enum DmpAdministrativeDataDictionary: string implements DictionaryInterface
{
    use ExtendedEnum;
    use DictionaryEnum;

    case PROJECT_NAME = 'projectName';
    case PROJECT_GOALS = 'projectGoals';
    case FUNDING = 'funding';
    case PROJECT_DURATION = 'projectDuration';
    case PROJECT_PARTNERS = 'projectPartners';
    case PRINCIPAL_INVESTIGATOR = 'principalInvestigator';
    case TARGET_AUDIENCES = 'targetAudiences';

    public function legend(): string
    {
        return match ($this) {
            self::PROJECT_NAME => 'data_management_plan.administrative_data.project_name.legend',
            self::PROJECT_GOALS => 'data_management_plan.administrative_data.project_goals.legend',
            self::FUNDING => 'data_management_plan.administrative_data.funding.legend',
            self::PROJECT_DURATION => 'data_management_plan.administrative_data.project_duration.legend',
            self::PROJECT_PARTNERS => 'data_management_plan.administrative_data.project_partners.legend',
            self::PRINCIPAL_INVESTIGATOR => 'data_management_plan.administrative_data.principal_investigator.legend',
            self::TARGET_AUDIENCES => 'data_management_plan.administrative_data.target_audiences.legend',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::PROJECT_NAME => 'data_management_plan.administrative_data.project_name.label',
            self::PROJECT_GOALS => 'data_management_plan.administrative_data.project_goals.label',
            self::FUNDING => 'data_management_plan.administrative_data.funding.label',
            self::PROJECT_DURATION => 'data_management_plan.administrative_data.project_duration.label',
            self::PROJECT_PARTNERS => 'data_management_plan.administrative_data.project_partners.label',
            self::PRINCIPAL_INVESTIGATOR => 'data_management_plan.administrative_data.principal_investigator.label',
            self::TARGET_AUDIENCES => 'data_management_plan.administrative_data.target_audiences.label',
        };
    }

    public function help(): ?string
    {
        return match ($this) {
            self::PROJECT_DURATION => 'data_management_plan.administrative_data.project_duration.help',
            default => null,
        };
    }

    public function descriptionHelp(): ?string
    {
        return match ($this) {
            self::TARGET_AUDIENCES => 'data_management_plan.administrative_data.target_audiences',
            default => null,
        };
    }

    public function reviewData(): ReviewDataDto
    {
        return match ($this) {
            self::PROJECT_NAME => new ReviewDataDto('data_management_plan.administrative_data.project_name.error_message', ErrorType::MANDATORY),
            self::PROJECT_GOALS => new ReviewDataDto('data_management_plan.administrative_data.project_goals.error_message', ErrorType::RECOMMENDED),
            self::FUNDING => new ReviewDataDto('data_management_plan.administrative_data.funding.error_message', ErrorType::RECOMMENDED),
            self::PROJECT_DURATION => new ReviewDataDto('data_management_plan.administrative_data.project_duration.error_message', ErrorType::OPTIONAL),
            self::PROJECT_PARTNERS => new ReviewDataDto('data_management_plan.administrative_data.project_partners.error_message', ErrorType::OPTIONAL),
            self::PRINCIPAL_INVESTIGATOR => new ReviewDataDto('data_management_plan.administrative_data.principal_investigator.error_message', ErrorType::MANDATORY),
            self::TARGET_AUDIENCES => new ReviewDataDto('data_management_plan.administrative_data.target_audiences.error_message', ErrorType::OPTIONAL),
        };
    }
}
