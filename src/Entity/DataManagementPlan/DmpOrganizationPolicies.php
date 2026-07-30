<?php

namespace App\Entity\DataManagementPlan;

use App\Entity\Administration\UuidEntity;
use App\Enum\YesNo;
use App\Repository\DataManagementPlan\DmpOrganizationPoliciesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Table(name: 'dmp_organization_policies')]
#[ORM\Entity(repositoryClass: DmpOrganizationPoliciesRepository::class)]
class DmpOrganizationPolicies extends UuidEntity
{
    #[ORM\OneToOne(inversedBy: 'organizationPolicies', cascade: ['persist', 'remove'])]
    protected ?DataManagementPlan $dataManagementPlan = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(length: 255, nullable: true, enumType: YesNo::class)]
    private ?YesNo $crossBorderCollaboration = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $crossBorderDataManagementRequirements = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $dataManagementResponsibilities = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $dataManagementPartners = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(length: 255, nullable: true, enumType: YesNo::class)]
    private ?YesNo $partnerInformed = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(length: 255, nullable: true, enumType: YesNo::class)]
    private ?YesNo $partnerContributionsDefined = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $partnerContributions = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(length: 255, nullable: true, enumType: YesNo::class)]
    private ?YesNo $partnerContributionsResponsibilityAcceptance = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $dataManagementWorkflowDescription = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $staffResourceAssessment = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $institutionPolicies = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $dataManagementPlanAdherence = null;

    public function getDataManagementPlan(): ?DataManagementPlan
    {
        return $this->dataManagementPlan;
    }

    public function setDataManagementPlan(?DataManagementPlan $dataManagementPlan): static
    {
        $this->dataManagementPlan = $dataManagementPlan;

        return $this;
    }

    public function getCrossBorderCollaboration(): ?YesNo
    {
        return $this->crossBorderCollaboration;
    }

    public function setCrossBorderCollaboration(?YesNo $crossBorderCollaboration): static
    {
        $this->crossBorderCollaboration = $crossBorderCollaboration;

        return $this;
    }

    public function getCrossBorderDataManagementRequirements(): ?string
    {
        return $this->crossBorderDataManagementRequirements;
    }

    public function setCrossBorderDataManagementRequirements(?string $crossBorderDataManagementRequirements): static
    {
        $this->crossBorderDataManagementRequirements = $crossBorderDataManagementRequirements;

        return $this;
    }

    public function getDataManagementResponsibilities(): ?string
    {
        return $this->dataManagementResponsibilities;
    }

    public function setDataManagementResponsibilities(?string $dataManagementResponsibilities): static
    {
        $this->dataManagementResponsibilities = $dataManagementResponsibilities;

        return $this;
    }

    public function getDataManagementPartners(): ?string
    {
        return $this->dataManagementPartners;
    }

    public function setDataManagementPartners(?string $dataManagementPartners): static
    {
        $this->dataManagementPartners = $dataManagementPartners;

        return $this;
    }

    public function getPartnerInformed(): ?YesNo
    {
        return $this->partnerInformed;
    }

    public function setPartnerInformed(?YesNo $partnerInformed): static
    {
        $this->partnerInformed = $partnerInformed;

        return $this;
    }

    public function getPartnerContributionsDefined(): ?YesNo
    {
        return $this->partnerContributionsDefined;
    }

    public function setPartnerContributionsDefined(?YesNo $partnerContributionsDefined): static
    {
        $this->partnerContributionsDefined = $partnerContributionsDefined;

        return $this;
    }

    public function getPartnerContributions(): ?string
    {
        return $this->partnerContributions;
    }

    public function setPartnerContributions(?string $partnerContributions): static
    {
        $this->partnerContributions = $partnerContributions;

        return $this;
    }

    public function getPartnerContributionsResponsibilityAcceptance(): ?YesNo
    {
        return $this->partnerContributionsResponsibilityAcceptance;
    }

    public function setPartnerContributionsResponsibilityAcceptance(?YesNo $partnerContributionsResponsibilityAcceptance): static
    {
        $this->partnerContributionsResponsibilityAcceptance = $partnerContributionsResponsibilityAcceptance;

        return $this;
    }

    public function getDataManagementWorkflowDescription(): ?string
    {
        return $this->dataManagementWorkflowDescription;
    }

    public function setDataManagementWorkflowDescription(?string $dataManagementWorkflowDescription): static
    {
        $this->dataManagementWorkflowDescription = $dataManagementWorkflowDescription;

        return $this;
    }

    public function getStaffResourceAssessment(): ?string
    {
        return $this->staffResourceAssessment;
    }

    public function setStaffResourceAssessment(?string $staffResourceAssessment): static
    {
        $this->staffResourceAssessment = $staffResourceAssessment;

        return $this;
    }

    public function getInstitutionPolicies(): ?string
    {
        return $this->institutionPolicies;
    }

    public function setInstitutionPolicies(?string $institutionPolicies): static
    {
        $this->institutionPolicies = $institutionPolicies;

        return $this;
    }

    public function getDataManagementPlanAdherence(): ?string
    {
        return $this->dataManagementPlanAdherence;
    }

    public function setDataManagementPlanAdherence(?string $dataManagementPlanAdherence): static
    {
        $this->dataManagementPlanAdherence = $dataManagementPlanAdherence;

        return $this;
    }
}
