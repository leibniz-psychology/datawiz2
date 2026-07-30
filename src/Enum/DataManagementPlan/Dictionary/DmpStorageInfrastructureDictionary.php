<?php

declare(strict_types=1);

namespace App\Enum\DataManagementPlan\Dictionary;

use App\Entity\Dto\ReviewDataDto;
use App\Enum\DictionaryEnum;
use App\Enum\DictionaryInterface;
use App\Enum\ErrorType;
use App\Enum\ExtendedEnum;

enum DmpStorageInfrastructureDictionary: string implements DictionaryInterface
{
    use ExtendedEnum;
    use DictionaryEnum;

    case RESPONSIBILITIES = 'responsibilities';
    case NAMING_CONVENTIONS = 'namingConventions';
    case STORAGE_LOCATIONS = 'storageLocations';
    case BACKUP_PLAN = 'backupPlan';
    case TRANSFER_DURING_PROJECT = 'transferDuringProject';
    case EXPECTED_VOLUME = 'expectedVolume';
    case SPECIFIC_TECHNICAL_REQUIREMENTS = 'specificTechnicalRequirements';
    case SUCCESSION_PLAN = 'successionPlan';

    public function legend(): string
    {
        return match ($this) {
            self::RESPONSIBILITIES => 'data_management_plan.storage_infrastructure.responsibilities.legend',
            self::NAMING_CONVENTIONS => 'data_management_plan.storage_infrastructure.naming_conventions.legend',
            self::STORAGE_LOCATIONS => 'data_management_plan.storage_infrastructure.storage_locations.legend',
            self::BACKUP_PLAN => 'data_management_plan.storage_infrastructure.backup_plan.legend',
            self::TRANSFER_DURING_PROJECT => 'data_management_plan.storage_infrastructure.transfer_during_project.legend',
            self::EXPECTED_VOLUME => 'data_management_plan.storage_infrastructure.expected_volume.legend',
            self::SPECIFIC_TECHNICAL_REQUIREMENTS => 'data_management_plan.storage_infrastructure.specific_technical_requirements.legend',
            self::SUCCESSION_PLAN => 'data_management_plan.storage_infrastructure.succession_plan.legend',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::RESPONSIBILITIES => 'data_management_plan.storage_infrastructure.responsibilities.label',
            self::NAMING_CONVENTIONS => 'data_management_plan.storage_infrastructure.naming_conventions.label',
            self::STORAGE_LOCATIONS => 'data_management_plan.storage_infrastructure.storage_locations.label',
            self::BACKUP_PLAN => 'data_management_plan.storage_infrastructure.backup_plan.label',
            self::TRANSFER_DURING_PROJECT => 'data_management_plan.storage_infrastructure.transfer_during_project.label',
            self::EXPECTED_VOLUME => 'data_management_plan.storage_infrastructure.expected_volume.label',
            self::SPECIFIC_TECHNICAL_REQUIREMENTS => 'data_management_plan.storage_infrastructure.specific_technical_requirements.label',
            self::SUCCESSION_PLAN => 'data_management_plan.storage_infrastructure.succession_plan.label',
        };
    }

    public function help(): ?string
    {
        return match ($this) {
            self::RESPONSIBILITIES => 'data_management_plan.storage_infrastructure.responsibilities.help',
            self::BACKUP_PLAN => 'data_management_plan.storage_infrastructure.backup_plan.help',
            self::TRANSFER_DURING_PROJECT => 'data_management_plan.storage_infrastructure.transfer_during_project.help',
            self::SPECIFIC_TECHNICAL_REQUIREMENTS => 'data_management_plan.storage_infrastructure.specific_technical_requirements.help',
            default => null,
        };
    }

    public function descriptionHelp(): ?string
    {
        return match ($this) {
            self::STORAGE_LOCATIONS => 'data_management_plan.storage_infrastructure.storage_locations',
            self::EXPECTED_VOLUME => 'data_management_plan.storage_infrastructure.expected_volume',
            default => null,
        };
    }

    public function reviewData(): ReviewDataDto
    {
        return match ($this) {
            self::RESPONSIBILITIES => new ReviewDataDto('data_management_plan.storage_infrastructure.responsibilities.error_message', ErrorType::RECOMMENDED),
            self::NAMING_CONVENTIONS => new ReviewDataDto('data_management_plan.storage_infrastructure.naming_conventions.error_message', ErrorType::RECOMMENDED),
            self::STORAGE_LOCATIONS => new ReviewDataDto('data_management_plan.storage_infrastructure.storage_locations.error_message', ErrorType::RECOMMENDED),
            self::BACKUP_PLAN => new ReviewDataDto('data_management_plan.storage_infrastructure.backup_plan.error_message', ErrorType::RECOMMENDED),
            self::TRANSFER_DURING_PROJECT => new ReviewDataDto('data_management_plan.storage_infrastructure.transfer_during_project.error_message', ErrorType::RECOMMENDED),
            self::EXPECTED_VOLUME => new ReviewDataDto('data_management_plan.storage_infrastructure.expected_volume.error_message', ErrorType::RECOMMENDED),
            self::SPECIFIC_TECHNICAL_REQUIREMENTS => new ReviewDataDto('data_management_plan.storage_infrastructure.specific_technical_requirements.error_message', ErrorType::RECOMMENDED),
            self::SUCCESSION_PLAN => new ReviewDataDto('data_management_plan.storage_infrastructure.succession_plan.error_message', ErrorType::RECOMMENDED),
        };
    }
}
