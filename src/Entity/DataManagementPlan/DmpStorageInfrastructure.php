<?php

namespace App\Entity\DataManagementPlan;

use App\Entity\Administration\UuidEntity;
use App\Repository\DataManagementPlan\DmpStorageInfrastructureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'dmp_storage_infrastructure')]
#[ORM\Entity(repositoryClass: DmpStorageInfrastructureRepository::class)]
class DmpStorageInfrastructure extends UuidEntity
{
    #[ORM\OneToOne(inversedBy: 'storageInfrastructure', cascade: ['persist', 'remove'])]
    protected ?DataManagementPlan $dataManagementPlan = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $responsibilities = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $namingConventions = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $storageLocations = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $backupPlan = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $transferDuringProject = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $expectedVolume = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $specificTechnicalRequirements = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $successionPlan = null;

    public function getDataManagementPlan(): ?DataManagementPlan
    {
        return $this->dataManagementPlan;
    }

    public function setDataManagementPlan(?DataManagementPlan $dataManagementPlan): static
    {
        $this->dataManagementPlan = $dataManagementPlan;

        return $this;
    }

    public function getResponsibilities(): ?string
    {
        return $this->responsibilities;
    }

    public function setResponsibilities(?string $responsibilities): static
    {
        $this->responsibilities = $responsibilities;

        return $this;
    }

    public function getNamingConventions(): ?string
    {
        return $this->namingConventions;
    }

    public function setNamingConventions(?string $namingConventions): static
    {
        $this->namingConventions = $namingConventions;

        return $this;
    }

    public function getStorageLocations(): ?string
    {
        return $this->storageLocations;
    }

    public function setStorageLocations(?string $storageLocations): static
    {
        $this->storageLocations = $storageLocations;

        return $this;
    }

    public function getBackupPlan(): ?string
    {
        return $this->backupPlan;
    }

    public function setBackupPlan(?string $backupPlan): static
    {
        $this->backupPlan = $backupPlan;

        return $this;
    }

    public function getTransferDuringProject(): ?string
    {
        return $this->transferDuringProject;
    }

    public function setTransferDuringProject(?string $transferDuringProject): static
    {
        $this->transferDuringProject = $transferDuringProject;

        return $this;
    }

    public function getExpectedVolume(): ?string
    {
        return $this->expectedVolume;
    }

    public function setExpectedVolume(?string $expectedVolume): static
    {
        $this->expectedVolume = $expectedVolume;

        return $this;
    }

    public function getSpecificTechnicalRequirements(): ?string
    {
        return $this->specificTechnicalRequirements;
    }

    public function setSpecificTechnicalRequirements(?string $specificTechnicalRequirements): static
    {
        $this->specificTechnicalRequirements = $specificTechnicalRequirements;

        return $this;
    }

    public function getSuccessionPlan(): ?string
    {
        return $this->successionPlan;
    }

    public function setSuccessionPlan(?string $successionPlan): static
    {
        $this->successionPlan = $successionPlan;

        return $this;
    }
}
