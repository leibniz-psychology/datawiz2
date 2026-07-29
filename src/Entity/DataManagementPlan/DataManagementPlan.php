<?php

declare(strict_types=1);

namespace App\Entity\DataManagementPlan;

use App\Entity\Administration\DataWizUser;
use App\Entity\Administration\UuidEntity;
use App\Repository\DataManagementPlan\DataManagementPlanRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ORM\Table(name: 'data_management_plan')]
#[ORM\Entity(repositoryClass: DataManagementPlanRepository::class)]
class DataManagementPlan extends UuidEntity
{
    #[SerializedName('administrative_data')]
    #[Groups(['data_management_plan'])]
    #[ORM\OneToOne(mappedBy: 'dataManagementPlan', cascade: ['persist', 'remove'])]
    private ?DmpAdministrativeData $administrativeData = null;

    #[SerializedName('research_data')]
    #[Groups(['data_management_plan'])]
    #[ORM\OneToOne(mappedBy: 'dataManagementPlan', cascade: ['persist', 'remove'])]
    private ?DmpResearchData $researchData = null;

    #[SerializedName('documentation')]
    #[Groups(['data_management_plan'])]
    #[ORM\OneToOne(mappedBy: 'dataManagementPlan', cascade: ['persist', 'remove'])]
    private ?DmpDocumentation $documentation = null;

    #[SerializedName('settings')]
    #[Groups(['settings'])]
    #[ORM\OneToOne(mappedBy: 'dataManagementPlan', cascade: ['persist', 'remove'])]
    private ?DmpSettings $settings = null;

    #[ORM\ManyToOne]
    private ?DataWizUser $owner = null;

    #[ORM\Column]
    #[Timestampable(on: 'create')]
    private ?\DateTime $dateCreated = null;

    public function getAdministrativeData(): ?DmpAdministrativeData
    {
        return $this->administrativeData;
    }

    public function setAdministrativeData(?DmpAdministrativeData $administrativeData): static
    {
        $this->administrativeData = $administrativeData;
        $administrativeData->setDataManagementPlan($this);
        return $this;
    }

    public function getResearchData(): ?DmpResearchData
    {
        return $this->researchData;
    }

    public function setResearchData(?DmpResearchData $researchData): static
    {
        $this->researchData = $researchData;
        $researchData->setDataManagementPlan($this);
        return $this;
    }

    public function getDocumentation(): ?DmpDocumentation
    {
        return $this->documentation;
    }

    public function setDocumentation(?DmpDocumentation $documentation): static
    {
        $this->documentation = $documentation;
        $documentation->setDataManagementPlan($this);
        return $this;
    }

    public function getSettings(): ?DmpSettings
    {
        return $this->settings;
    }

    public function setSettings(?DmpSettings $settings): static
    {
        $this->settings = $settings;
        $settings->setDataManagementPlan($this);
        return $this;
    }

    public function getOwner(): ?DataWizUser
    {
        return $this->owner;
    }

    public function setOwner(?DataWizUser $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getDateCreated(): \DateTime
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTime $dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }
}
