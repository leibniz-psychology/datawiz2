<?php

declare(strict_types=1);

namespace App\Enum\DataManagementPlan\Dictionary;

use App\Entity\Dto\ReviewDataDto;
use App\Enum\DictionaryEnum;
use App\Enum\DictionaryInterface;
use App\Enum\ErrorType;
use App\Enum\ExtendedEnum;

enum DmpOrganizationPoliciesDictionary: string implements DictionaryInterface
{
    use ExtendedEnum;
    use DictionaryEnum;

    case CROSS_BORDER_COLLABORATION = 'crossBorderCollaboration';
    case CROSS_BORDER_DATA_MANAGEMENT_REQUIREMENTS = 'crossBorderDataManagementRequirements';
    case DATA_MANAGEMENT_RESPONSIBILITIES = 'dataManagementResponsibilities';
    case DATA_MANAGEMENT_PARTNERS = 'dataManagementPartners';
    case PARTNER_INFORMED = 'partnerInformed';
    case PARTNER_CONTRIBUTIONS_DEFINED = 'partnerContributionsDefined';
    case PARTNER_CONTRIBUTIONS = 'partnerContributions';
    case PARTNER_CONTRIBUTIONS_RESPONSIBILITY_ACCEPTANCE = 'partnerContributionsResponsibilityAcceptance';
    case DATA_MANAGEMENT_WORKFLOW_DESCRIPTION = 'dataManagementWorkflowDescription';
    case STAFF_RESOURCE_ASSESSMENT = 'staffResourceAssessment';
    case INSTITUTION_POLICIES = 'institutionPolicies';
    case DATA_MANAGEMENT_PLAN_ADHERENCE = 'dataManagementPlanAdherence';

    public function legend(): string
    {
        return match ($this) {
            self::CROSS_BORDER_COLLABORATION => 'data_management_plan.organization_policies.cross_border_collaboration.legend',
            self::CROSS_BORDER_DATA_MANAGEMENT_REQUIREMENTS => 'data_management_plan.organization_policies.cross_border_data_management_requirements.legend',
            self::DATA_MANAGEMENT_RESPONSIBILITIES => 'data_management_plan.organization_policies.data_management_responsibilities.legend',
            self::DATA_MANAGEMENT_PARTNERS => 'data_management_plan.organization_policies.data_management_partners.legend',
            self::PARTNER_INFORMED => 'data_management_plan.organization_policies.partner_informed.legend',
            self::PARTNER_CONTRIBUTIONS_DEFINED => 'data_management_plan.organization_policies.partner_contributions_defined.legend',
            self::PARTNER_CONTRIBUTIONS => 'data_management_plan.organization_policies.partner_contributions.legend',
            self::PARTNER_CONTRIBUTIONS_RESPONSIBILITY_ACCEPTANCE => 'data_management_plan.organization_policies.partner_contributions_responsibility_acceptance.legend',
            self::DATA_MANAGEMENT_WORKFLOW_DESCRIPTION => 'data_management_plan.organization_policies.data_management_workflow_description.legend',
            self::STAFF_RESOURCE_ASSESSMENT => 'data_management_plan.organization_policies.staff_resource_assessment.legend',
            self::INSTITUTION_POLICIES => 'data_management_plan.organization_policies.institution_policies.legend',
            self::DATA_MANAGEMENT_PLAN_ADHERENCE => 'data_management_plan.organization_policies.data_management_plan_adherence.legend',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::CROSS_BORDER_COLLABORATION => 'data_management_plan.organization_policies.cross_border_collaboration.label',
            self::CROSS_BORDER_DATA_MANAGEMENT_REQUIREMENTS => 'data_management_plan.organization_policies.cross_border_data_management_requirements.label',
            self::DATA_MANAGEMENT_RESPONSIBILITIES => 'data_management_plan.organization_policies.data_management_responsibilities.label',
            self::DATA_MANAGEMENT_PARTNERS => 'data_management_plan.organization_policies.data_management_partners.label',
            self::PARTNER_INFORMED => 'data_management_plan.organization_policies.partner_informed.label',
            self::PARTNER_CONTRIBUTIONS_DEFINED => 'data_management_plan.organization_policies.partner_contributions_defined.label',
            self::PARTNER_CONTRIBUTIONS => 'data_management_plan.organization_policies.partner_contributions.label',
            self::PARTNER_CONTRIBUTIONS_RESPONSIBILITY_ACCEPTANCE => 'data_management_plan.organization_policies.partner_contributions_responsibility_acceptance.label',
            self::DATA_MANAGEMENT_WORKFLOW_DESCRIPTION => 'data_management_plan.organization_policies.data_management_workflow_description.label',
            self::STAFF_RESOURCE_ASSESSMENT => 'data_management_plan.organization_policies.staff_resource_assessment.label',
            self::INSTITUTION_POLICIES => 'data_management_plan.organization_policies.institution_policies.label',
            self::DATA_MANAGEMENT_PLAN_ADHERENCE => 'data_management_plan.organization_policies.data_management_plan_adherence.label',
        };
    }

    public function placeholder(): ?string
    {
        return match ($this) {
            self::CROSS_BORDER_COLLABORATION => 'data_management_plan.organization_policies.cross_border_collaboration.placeholder',
            self::PARTNER_INFORMED => 'data_management_plan.organization_policies.partner_informed.placeholder',
            self::PARTNER_CONTRIBUTIONS_DEFINED => 'data_management_plan.organization_policies.partner_contributions_defined.placeholder',
            self::PARTNER_CONTRIBUTIONS_RESPONSIBILITY_ACCEPTANCE => 'data_management_plan.organization_policies.partner_contributions_responsibility_acceptance.placeholder',
            default => null,
        };
    }

    public function help(): ?string
    {
        return match ($this) {
            self::CROSS_BORDER_COLLABORATION => 'data_management_plan.organization_policies.cross_border_collaboration.help',
            self::CROSS_BORDER_DATA_MANAGEMENT_REQUIREMENTS => 'data_management_plan.organization_policies.cross_border_data_management_requirements.help',
            self::STAFF_RESOURCE_ASSESSMENT => 'data_management_plan.organization_policies.staff_resource_assessment.help',
            default => null,
        };
    }

    public function reviewData(): ReviewDataDto
    {
        return match ($this) {
            self::CROSS_BORDER_COLLABORATION => new ReviewDataDto('data_management_plan.organization_policies.cross_border_collaboration.error_message', ErrorType::RECOMMENDED),
            self::CROSS_BORDER_DATA_MANAGEMENT_REQUIREMENTS => new ReviewDataDto('data_management_plan.organization_policies.cross_border_data_management_requirements.error_message', ErrorType::RECOMMENDED),
            self::DATA_MANAGEMENT_RESPONSIBILITIES => new ReviewDataDto('data_management_plan.organization_policies.data_management_responsibilities.error_message', ErrorType::RECOMMENDED),
            self::DATA_MANAGEMENT_PARTNERS => new ReviewDataDto('data_management_plan.organization_policies.data_management_partners.error_message', ErrorType::RECOMMENDED),
            self::PARTNER_INFORMED => new ReviewDataDto('data_management_plan.organization_policies.partner_informed.error_message', ErrorType::RECOMMENDED),
            self::PARTNER_CONTRIBUTIONS_DEFINED => new ReviewDataDto('data_management_plan.organization_policies.partner_contributions_defined.error_message', ErrorType::RECOMMENDED),
            self::PARTNER_CONTRIBUTIONS => new ReviewDataDto('data_management_plan.organization_policies.partner_contributions.error_message', ErrorType::RECOMMENDED),
            self::PARTNER_CONTRIBUTIONS_RESPONSIBILITY_ACCEPTANCE => new ReviewDataDto('data_management_plan.organization_policies.partner_contributions_responsibility_acceptance.error_message', ErrorType::RECOMMENDED),
            self::DATA_MANAGEMENT_WORKFLOW_DESCRIPTION => new ReviewDataDto('data_management_plan.organization_policies.data_management_workflow_description.error_message', ErrorType::RECOMMENDED),
            self::STAFF_RESOURCE_ASSESSMENT => new ReviewDataDto('data_management_plan.organization_policies.staff_resource_assessment.error_message', ErrorType::RECOMMENDED),
            self::INSTITUTION_POLICIES => new ReviewDataDto('data_management_plan.organization_policies.institution_policies.error_message', ErrorType::RECOMMENDED),
            self::DATA_MANAGEMENT_PLAN_ADHERENCE => new ReviewDataDto('data_management_plan.organization_policies.data_management_plan_adherence.error_message', ErrorType::RECOMMENDED),
        };
    }
}
