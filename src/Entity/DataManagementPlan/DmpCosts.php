<?php

namespace App\Entity\DataManagementPlan;

use App\Entity\Administration\UuidEntity;
use App\Enum\DataManagementPlan\DataManagementCosting;
use App\Repository\DataManagementPlan\DmpCostsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'dmp_costs')]
#[ORM\Entity(repositoryClass: DmpCostsRepository::class)]
class DmpCosts extends UuidEntity
{
    #[ORM\OneToOne(inversedBy: 'costs', cascade: ['persist', 'remove'])]
    protected ?DataManagementPlan $dataManagementPlan = null;

    #[ORM\Column(length: 255, nullable: true, enumType: DataManagementCosting::class)]
    private ?DataManagementCosting $dataManagementCosting = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $costsAssessment = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $costsAssumption = null;

    public function getDataManagementPlan(): ?DataManagementPlan
    {
        return $this->dataManagementPlan;
    }

    public function setDataManagementPlan(?DataManagementPlan $dataManagementPlan): static
    {
        $this->dataManagementPlan = $dataManagementPlan;

        return $this;
    }

    public function getDataManagementCosting(): ?DataManagementCosting
    {
        return $this->dataManagementCosting;
    }

    public function setDataManagementCosting(?DataManagementCosting $dataManagementCosting): static
    {
        $this->dataManagementCosting = $dataManagementCosting;

        return $this;
    }

    public function getCostsAssessment(): ?string
    {
        return $this->costsAssessment;
    }

    public function setCostsAssessment(?string $costsAssessment): static
    {
        $this->costsAssessment = $costsAssessment;

        return $this;
    }

    public function getCostsAssumption(): ?string
    {
        return $this->costsAssumption;
    }

    public function setCostsAssumption(?string $costsAssumption): static
    {
        $this->costsAssumption = $costsAssumption;

        return $this;
    }
}
