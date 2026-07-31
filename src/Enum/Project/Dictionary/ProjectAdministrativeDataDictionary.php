<?php

declare(strict_types=1);

namespace App\Enum\Project\Dictionary;

use App\Entity\Dto\ReviewDataDto;
use App\Enum\DictionaryEnum;
use App\Enum\DictionaryInterface;
use App\Enum\ErrorType;
use App\Enum\ExtendedEnum;

enum ProjectAdministrativeDataDictionary: string implements DictionaryInterface
{
    use ExtendedEnum;
    use DictionaryEnum;

    case PROJECT_TITLE = 'projectTitle';
    case PROJECT_ID = 'projectId';
    case PROJECT_OBJECTIVES = 'projectObjectives';
    case FUNDING = 'funding';
    case GRANT_NUMBER = 'grantNumber';

    public function legend(): string
    {
        return match ($this) {
            self::PROJECT_TITLE => 'project.administrative_data.project_title.legend',
            self::PROJECT_ID => 'project.administrative_data.project_id.legend',
            self::PROJECT_OBJECTIVES => 'project.administrative_data.project_objectives.legend',
            self::FUNDING => 'project.administrative_data.funding.legend',
            self::GRANT_NUMBER => 'project.administrative_data.grant_number.legend',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::PROJECT_TITLE => 'project.administrative_data.project_title.label',
            self::PROJECT_ID => 'project.administrative_data.project_id.label',
            self::PROJECT_OBJECTIVES => 'project.administrative_data.project_objectives.label',
            self::FUNDING => 'project.administrative_data.funding.label',
            self::GRANT_NUMBER => 'project.administrative_data.grant_number.label',
        };
    }

    public function help(): ?string
    {
        return match ($this) {
            self::FUNDING => 'project.administrative_data.funding.help',
            default => null,
        };
    }

    public function descriptionHelp(): ?string
    {
        return null;
    }

    public function reviewData(): ReviewDataDto
    {
        return match ($this) {
            self::PROJECT_TITLE => new ReviewDataDto('project.administrative_data.project_title.error_message', ErrorType::MANDATORY),
            self::PROJECT_ID => new ReviewDataDto('project.administrative_data.project_id.error_message', ErrorType::RECOMMENDED),
            self::PROJECT_OBJECTIVES => new ReviewDataDto('project.administrative_data.project_objectives.error_message', ErrorType::MANDATORY),
            self::FUNDING => new ReviewDataDto('project.administrative_data.funding.error_message', ErrorType::RECOMMENDED),
            self::GRANT_NUMBER => new ReviewDataDto('project.administrative_data.grant_number.error_message', ErrorType::OPTIONAL),
        };
    }
}
