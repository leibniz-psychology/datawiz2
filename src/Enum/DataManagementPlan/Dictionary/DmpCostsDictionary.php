<?php

declare(strict_types=1);

namespace App\Enum\DataManagementPlan\Dictionary;

use App\Entity\Dto\ReviewDataDto;
use App\Enum\DictionaryEnum;
use App\Enum\DictionaryInterface;
use App\Enum\ErrorType;
use App\Enum\ExtendedEnum;

enum DmpCostsDictionary: string implements DictionaryInterface
{
    use ExtendedEnum;
    use DictionaryEnum;

    case DATA_MANAGEMENT_COSTING = 'dataManagementCosting';
    case COSTS_ASSESSMENT = 'costsAssessment';
    case COSTS_ASSUMPTION = 'costsAssumption';

    public function legend(): string
    {
        return match ($this) {
            self::DATA_MANAGEMENT_COSTING => 'data_management_plan.costs.data_management_costing.legend',
            self::COSTS_ASSESSMENT => 'data_management_plan.costs.costs_assessment.legend',
            self::COSTS_ASSUMPTION => 'data_management_plan.costs.costs_assumption.legend',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::DATA_MANAGEMENT_COSTING => 'data_management_plan.costs.data_management_costing.label',
            self::COSTS_ASSESSMENT => 'data_management_plan.costs.costs_assessment.label',
            self::COSTS_ASSUMPTION => 'data_management_plan.costs.costs_assumption.label',
        };
    }

    public function placeholder(): ?string
    {
        return match ($this) {
            self::DATA_MANAGEMENT_COSTING => 'data_management_plan.costs.data_management_costing.placeholder',
            default => null,
        };
    }

    public function help(): ?string
    {
        return match ($this) {
            self::COSTS_ASSUMPTION => 'data_management_plan.costs.costs_assumption.help',
            default => null,
        };
    }

    public function descriptionHelp(): ?string
    {
        return match ($this) {
            self::DATA_MANAGEMENT_COSTING => 'data_management_plan.costs.data_management_costing',
            default => null,
        };
    }

    public function reviewData(): ReviewDataDto
    {
        return match ($this) {
            self::DATA_MANAGEMENT_COSTING => new ReviewDataDto('data_management_plan.costs.data_management_costing.error_message', ErrorType::RECOMMENDED),
            self::COSTS_ASSESSMENT => new ReviewDataDto('data_management_plan.costs.costs_assessment.error_message', ErrorType::RECOMMENDED),
            self::COSTS_ASSUMPTION => new ReviewDataDto('data_management_plan.costs.costs_assumption.error_message', ErrorType::RECOMMENDED),
        };
    }
}
