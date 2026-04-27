<?php

namespace App\Enum;

enum CreatorCreditRole: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case CONCEPTUALIZATION = 'Conceptualization';
    case DATA_CURATION = 'Data curation';
    case FORMAL_ANALYSIS = 'Formal analysis';
    case FUNDING_ACQUISITION = 'Funding acquisition';
    case INVESTIGATION = 'Investigation';
    case METHODOLOGY = 'Methodology';
    case PROJECT_ADMINISTRATION = 'Project administration';
    case RESOURCES = 'Resources';
    case SOFTWARE = 'Software';
    case SUPERVISION = 'Supervision';
    case VALIDATION = 'Validation';
    case VISUALIZATION = 'Visualization';

    case WRITING_ORIGINAL_DRAFT = 'Writing - original draft';
    case WRITING_REVIEW_EDITING = 'Writing - review & editing';

    public function label(): string
    {
        return match ($this) {
            self::CONCEPTUALIZATION => 'creator_credit_role.conceptualization',
            self::DATA_CURATION => 'creator_credit_role.data_curation',
            self::FORMAL_ANALYSIS => 'creator_credit_role.formal_analysis',
            self::FUNDING_ACQUISITION => 'creator_credit_role.funding_acquisition',
            self::INVESTIGATION => 'creator_credit_role.investigation',
            self::METHODOLOGY => 'creator_credit_role.methodology',
            self::PROJECT_ADMINISTRATION => 'creator_credit_role.project_administration',
            self::RESOURCES => 'creator_credit_role.resources',
            self::SOFTWARE => 'creator_credit_role.software',
            self::SUPERVISION => 'creator_credit_role.supervision',
            self::VALIDATION => 'creator_credit_role.validation',
            self::VISUALIZATION => 'creator_credit_role.visualization',
            self::WRITING_ORIGINAL_DRAFT => 'creator_credit_role.writing_original_draft',
            self::WRITING_REVIEW_EDITING => 'creator_credit_role.writing_review_editing',
        };
    }
}
