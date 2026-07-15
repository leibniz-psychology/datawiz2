<?php

/**
 * This class provides the short name metadata.
 */

namespace App\Entity\DataManagementPlan;

use App\Entity\Administration\UuidEntity;
use App\Repository\DataManagementPlan\DmpAdministrativeDataRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'dmp_administrative_data')]
#[ORM\Entity(repositoryClass: DmpAdministrativeDataRepository::class)]
class DmpAdministrativeData extends UuidEntity
{
    /**
     * One Settings section has One Experiment.
     */
    #[ORM\OneToOne(inversedBy: 'administrativeData', cascade: ['persist', 'remove'])]
    protected ?DataManagementPlan $dataManagementPlan = null;

    #[ORM\Column(length: 255)]
    private ?string $projectName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $projectGoals = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $funding = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $projectDuration = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $projectPartners = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $principalInvestigator = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $targetAudiences = null;

    public function getDataManagementPlan(): ?DataManagementPlan
    {
        return $this->dataManagementPlan;
    }

    public function setDataManagementPlan(?DataManagementPlan $dataManagementPlan): static
    {
        $this->dataManagementPlan = $dataManagementPlan;
        return $this;
    }

    public function getProjectName(): ?string
    {
        return $this->projectName;
    }

    public function setProjectName(?string $projectName): static
    {
        $this->projectName = $projectName;

        return $this;
    }

    public function getProjectGoals(): ?string
    {
        return $this->projectGoals;
    }

    public function setProjectGoals(?string $projectGoals): static
    {
        $this->projectGoals = $projectGoals;

        return $this;
    }

    public function getFunding(): ?string
    {
        return $this->funding;
    }

    public function setFunding(?string $funding): static
    {
        $this->funding = $funding;

        return $this;
    }

    public function getProjectDuration(): ?string
    {
        return $this->projectDuration;
    }

    public function setProjectDuration(?string $projectDuration): static
    {
        $this->projectDuration = $projectDuration;

        return $this;
    }

    public function getProjectPartners(): ?string
    {
        return $this->projectPartners;
    }

    public function setProjectPartners(?string $projectPartners): static
    {
        $this->projectPartners = $projectPartners;

        return $this;
    }

    public function getPrincipalInvestigator(): ?string
    {
        return $this->principalInvestigator;
    }

    public function setPrincipalInvestigator(?string $principalInvestigator): static
    {
        $this->principalInvestigator = $principalInvestigator;

        return $this;
    }

    public function getTargetAudiences(): ?string
    {
        return $this->targetAudiences;
    }

    public function setTargetAudiences(?string $targetAudiences): static
    {
        $this->targetAudiences = $targetAudiences;

        return $this;
    }
}
