<?php

declare(strict_types=1);

namespace App\Enum\DataManagementPlan\Dictionary;

use App\Entity\Dto\ReviewDataDto;
use App\Enum\DictionaryEnum;
use App\Enum\DictionaryInterface;
use App\Enum\ErrorType;
use App\Enum\ExtendedEnum;

enum DmpDocumentationDictionary: string implements DictionaryInterface
{
    use ExtendedEnum;
    use DictionaryEnum;

    case PURPOSE = 'purpose';
    case CONTENT = 'content';
    case STANDARDIZATION = 'standardization';
    case GENERATING_PROCEDURE = 'generatingProcedure';
    case MONITORING = 'monitoring';
    case EXCHANGE_AND_STORAGE_FORMAT = 'exchangeAndStorageFormat';

    public function legend(): string
    {
        return match ($this) {
            self::PURPOSE => 'data_management_plan.documentation.purpose.legend',
            self::CONTENT => 'data_management_plan.documentation.content.legend',
            self::STANDARDIZATION => 'data_management_plan.documentation.standardization.legend',
            self::GENERATING_PROCEDURE => 'data_management_plan.documentation.generating_procedure.legend',
            self::MONITORING => 'data_management_plan.documentation.monitoring.legend',
            self::EXCHANGE_AND_STORAGE_FORMAT => 'data_management_plan.documentation.exchange_and_storage_format.legend',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::PURPOSE => 'data_management_plan.documentation.purpose.label',
            self::CONTENT => 'data_management_plan.documentation.content.label',
            self::STANDARDIZATION => 'data_management_plan.documentation.standardization.label',
            self::GENERATING_PROCEDURE => 'data_management_plan.documentation.generating_procedure.label',
            self::MONITORING => 'data_management_plan.documentation.monitoring.label',
            self::EXCHANGE_AND_STORAGE_FORMAT => 'data_management_plan.documentation.exchange_and_storage_format.label',
        };
    }

    public function descriptionHelp(): ?string
    {
        return match ($this) {
            self::PURPOSE => 'data_management_plan.documentation.purpose',
            self::CONTENT => 'data_management_plan.documentation.content',
            self::STANDARDIZATION => 'data_management_plan.documentation.standardization',
            self::GENERATING_PROCEDURE => 'data_management_plan.documentation.generating_procedure',
            self::MONITORING => 'data_management_plan.documentation.monitoring',
            default => null,
        };
    }

    public function reviewData(): ReviewDataDto
    {
        return match ($this) {
            self::PURPOSE => new ReviewDataDto('data_management_plan.documentation.purpose.error_message', ErrorType::RECOMMENDED),
            self::CONTENT => new ReviewDataDto('data_management_plan.documentation.content.error_message', ErrorType::RECOMMENDED),
            self::STANDARDIZATION => new ReviewDataDto('data_management_plan.documentation.standardization.error_message', ErrorType::RECOMMENDED),
            self::GENERATING_PROCEDURE => new ReviewDataDto('data_management_plan.documentation.generating_procedure.error_message', ErrorType::RECOMMENDED),
            self::MONITORING => new ReviewDataDto('data_management_plan.documentation.monitoring.error_message', ErrorType::RECOMMENDED),
            self::EXCHANGE_AND_STORAGE_FORMAT => new ReviewDataDto('data_management_plan.documentation.exchange_and_storage_format.error_message', ErrorType::RECOMMENDED),
        };
    }
}
