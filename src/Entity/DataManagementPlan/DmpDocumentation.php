<?php

namespace App\Entity\DataManagementPlan;

use App\Entity\Administration\UuidEntity;
use App\Enum\DataManagementPlan\DocumentationPurpose;
use App\Repository\DataManagementPlan\DmpDocumentationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'dmp_documentation')]
#[ORM\Entity(repositoryClass: DmpDocumentationRepository::class)]
class DmpDocumentation extends UuidEntity
{
    #[ORM\OneToOne(inversedBy: 'documentation', cascade: ['persist', 'remove'])]
    protected ?DataManagementPlan $dataManagementPlan = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true, enumType: DocumentationPurpose::class)]
    private ?array $purpose = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $standardization = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $generatingProcedure = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $monitoring = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $exchangeAndStorageFormat = null;

    public function getDataManagementPlan(): ?DataManagementPlan
    {
        return $this->dataManagementPlan;
    }

    public function setDataManagementPlan(?DataManagementPlan $dataManagementPlan): static
    {
        $this->dataManagementPlan = $dataManagementPlan;

        return $this;
    }

    public function getPurpose(): ?array
    {
        return $this->purpose;
    }

    public function setPurpose(?array $purpose): static
    {
        $this->purpose = $purpose;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getStandardization(): ?string
    {
        return $this->standardization;
    }

    public function setStandardization(?string $standardization): static
    {
        $this->standardization = $standardization;

        return $this;
    }

    public function getGeneratingProcedure(): ?string
    {
        return $this->generatingProcedure;
    }

    public function setGeneratingProcedure(?string $generatingProcedure): static
    {
        $this->generatingProcedure = $generatingProcedure;

        return $this;
    }

    public function getMonitoring(): ?string
    {
        return $this->monitoring;
    }

    public function setMonitoring(?string $monitoring): static
    {
        $this->monitoring = $monitoring;

        return $this;
    }

    public function getExchangeAndStorageFormat(): ?string
    {
        return $this->exchangeAndStorageFormat;
    }

    public function setExchangeAndStorageFormat(?string $exchangeAndStorageFormat): static
    {
        $this->exchangeAndStorageFormat = $exchangeAndStorageFormat;

        return $this;
    }
}
