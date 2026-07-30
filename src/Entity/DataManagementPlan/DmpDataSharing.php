<?php

namespace App\Entity\DataManagementPlan;

use App\Entity\Administration\UuidEntity;
use App\Enum\DataManagementPlan\NoSharingExplanation;
use App\Enum\DataManagementPlan\PersistentIdentifierUse;
use App\Enum\DataManagementPlan\ThirdPartyAccess;
use App\Enum\YesNo;
use App\Repository\DataManagementPlan\DmpDataSharingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Table(name: 'dmp_data_sharing')]
#[ORM\Entity(repositoryClass: DmpDataSharingRepository::class)]
class DmpDataSharing extends UuidEntity
{
    #[ORM\OneToOne(inversedBy: 'dataSharing', cascade: ['persist', 'remove'])]
    protected ?DataManagementPlan $dataManagementPlan = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(length: 255, nullable: true, enumType: YesNo::class)]
    private ?YesNo $sharingObligation = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $intendedUse = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(length: 255, nullable: true, enumType: ThirdPartyAccess::class)]
    private ?ThirdPartyAccess $thirdPartyAccess = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $repositoryName = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $dataSearchability = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $depositTimepoint = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $sensitiveDataRequirements = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $initialUseRight = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $usageRestriction = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(length: 255, nullable: true, enumType: YesNo::class)]
    private ?YesNo $accessCost = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(length: 255, nullable: true, enumType: YesNo::class)]
    private ?YesNo $repositoryResponsibilitiesFixation = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(length: 255, nullable: true, enumType: YesNo::class)]
    private ?YesNo $acquisitionAgreement = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(length: 255, nullable: true, enumType: PersistentIdentifierUse::class)]
    private ?PersistentIdentifierUse $persistentIdentifierUse = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $persistentIdentifierUseOtherDescription = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $noRepositoryExplanation = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(length: 255, nullable: true, enumType: NoSharingExplanation::class)]
    private ?NoSharingExplanation $noSharingExplanation = null;

    #[Groups(['data_management_plan'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $noSharingExplanationOtherDescription = null;

    public function getDataManagementPlan(): ?DataManagementPlan
    {
        return $this->dataManagementPlan;
    }

    public function setDataManagementPlan(?DataManagementPlan $dataManagementPlan): static
    {
        $this->dataManagementPlan = $dataManagementPlan;

        return $this;
    }

    public function getSharingObligation(): ?YesNo
    {
        return $this->sharingObligation;
    }

    public function setSharingObligation(?YesNo $sharingObligation): static
    {
        $this->sharingObligation = $sharingObligation;

        return $this;
    }

    public function getIntendedUse(): ?string
    {
        return $this->intendedUse;
    }

    public function setIntendedUse(?string $intendedUse): static
    {
        $this->intendedUse = $intendedUse;

        return $this;
    }

    public function getThirdPartyAccess(): ?ThirdPartyAccess
    {
        return $this->thirdPartyAccess;
    }

    public function setThirdPartyAccess(?ThirdPartyAccess $thirdPartyAccess): static
    {
        $this->thirdPartyAccess = $thirdPartyAccess;

        return $this;
    }

    public function getRepositoryName(): ?string
    {
        return $this->repositoryName;
    }

    public function setRepositoryName(?string $repositoryName): static
    {
        $this->repositoryName = $repositoryName;

        return $this;
    }

    public function getDataSearchability(): ?string
    {
        return $this->dataSearchability;
    }

    public function setDataSearchability(?string $dataSearchability): static
    {
        $this->dataSearchability = $dataSearchability;

        return $this;
    }

    public function getDepositTimepoint(): ?string
    {
        return $this->depositTimepoint;
    }

    public function setDepositTimepoint(?string $depositTimepoint): static
    {
        $this->depositTimepoint = $depositTimepoint;

        return $this;
    }

    public function getSensitiveDataRequirements(): ?string
    {
        return $this->sensitiveDataRequirements;
    }

    public function setSensitiveDataRequirements(?string $sensitiveDataRequirements): static
    {
        $this->sensitiveDataRequirements = $sensitiveDataRequirements;

        return $this;
    }

    public function getInitialUseRight(): ?string
    {
        return $this->initialUseRight;
    }

    public function setInitialUseRight(?string $initialUseRight): static
    {
        $this->initialUseRight = $initialUseRight;

        return $this;
    }

    public function getUsageRestriction(): ?string
    {
        return $this->usageRestriction;
    }

    public function setUsageRestriction(?string $usageRestriction): static
    {
        $this->usageRestriction = $usageRestriction;

        return $this;
    }

    public function getAccessCost(): ?YesNo
    {
        return $this->accessCost;
    }

    public function setAccessCost(?YesNo $accessCost): static
    {
        $this->accessCost = $accessCost;

        return $this;
    }

    public function getRepositoryResponsibilitiesFixation(): ?YesNo
    {
        return $this->repositoryResponsibilitiesFixation;
    }

    public function setRepositoryResponsibilitiesFixation(?YesNo $repositoryResponsibilitiesFixation): static
    {
        $this->repositoryResponsibilitiesFixation = $repositoryResponsibilitiesFixation;

        return $this;
    }

    public function getAcquisitionAgreement(): ?YesNo
    {
        return $this->acquisitionAgreement;
    }

    public function setAcquisitionAgreement(?YesNo $acquisitionAgreement): static
    {
        $this->acquisitionAgreement = $acquisitionAgreement;

        return $this;
    }

    public function getPersistentIdentifierUse(): ?PersistentIdentifierUse
    {
        return $this->persistentIdentifierUse;
    }

    public function setPersistentIdentifierUse(?PersistentIdentifierUse $persistentIdentifierUse): static
    {
        $this->persistentIdentifierUse = $persistentIdentifierUse;

        return $this;
    }

    public function getPersistentIdentifierUseOtherDescription(): ?string
    {
        return $this->persistentIdentifierUseOtherDescription;
    }

    public function setPersistentIdentifierUseOtherDescription(?string $persistentIdentifierUseOtherDescription): static
    {
        $this->persistentIdentifierUseOtherDescription = $persistentIdentifierUseOtherDescription;

        return $this;
    }

    public function getNoRepositoryExplanation(): ?string
    {
        return $this->noRepositoryExplanation;
    }

    public function setNoRepositoryExplanation(?string $noRepositoryExplanation): static
    {
        $this->noRepositoryExplanation = $noRepositoryExplanation;

        return $this;
    }

    public function getNoSharingExplanation(): ?NoSharingExplanation
    {
        return $this->noSharingExplanation;
    }

    public function setNoSharingExplanation(?NoSharingExplanation $noSharingExplanation): static
    {
        $this->noSharingExplanation = $noSharingExplanation;

        return $this;
    }

    public function getNoSharingExplanationOtherDescription(): ?string
    {
        return $this->noSharingExplanationOtherDescription;
    }

    public function setNoSharingExplanationOtherDescription(?string $noSharingExplanationOtherDescription): static
    {
        $this->noSharingExplanationOtherDescription = $noSharingExplanationOtherDescription;

        return $this;
    }
}
