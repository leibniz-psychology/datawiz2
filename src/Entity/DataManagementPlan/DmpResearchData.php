<?php

namespace App\Entity\DataManagementPlan;

use App\Entity\Administration\UuidEntity;
use App\Enum\DataManagementPlan\ExistingDataReuse;
use App\Enum\DataManagementPlan\ResearchMethod;
use App\Enum\Study\CollectionMode;
use App\Enum\Study\ResearchDesign;
use App\Enum\YesNo;
use App\Repository\DataManagementPlan\DmpResearchDataRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'dmp_research_data')]
#[ORM\Entity(repositoryClass: DmpResearchDataRepository::class)]
class DmpResearchData extends UuidEntity
{
    #[ORM\OneToOne(inversedBy: 'researchData', cascade: ['persist', 'remove'])]
    protected ?DataManagementPlan $dataManagementPlan = null;

    #[ORM\Column(length: 255, nullable: true, enumType: ExistingDataReuse::class)]
    private ?ExistingDataReuse $existingDataReuse = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $existingDataCitation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $existingDataRelevance = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $existingDataIntegration = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true, enumType: ResearchMethod::class)]
    private ?array $researchMethod = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $researchMethodOtherDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $dataCollectionReproducibility = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true, enumType: CollectionMode::class)]
    private ?array $collectionMode = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $collectionApparatus = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $collectionModeOtherDescription = null;

    #[ORM\Column(length: 255, nullable: true, enumType: ResearchDesign::class)]
    private ?ResearchDesign $researchDesign = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $dataCollectorTraining = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $constructsMultipleMeasurement = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $qualityAssuranceOtherDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $fileFormats = null;

    #[ORM\Column(length: 255, nullable: true, enumType: YesNo::class)]
    private ?YesNo $dataPreservationWorkingCopy = null;

    #[ORM\Column(length: 255, nullable: true, enumType: YesNo::class)]
    private ?YesNo $dataPreservationGoodScientificPracticeProof = null;

    #[ORM\Column(length: 255, nullable: true, enumType: YesNo::class)]
    private ?YesNo $dataPreservationReproducibility = null;

    #[ORM\Column(length: 255, nullable: true, enumType: YesNo::class)]
    private ?YesNo $dataPreservationLegalObligations = null;

    #[ORM\Column(length: 255, nullable: true, enumType: YesNo::class)]
    private ?YesNo $dataPreservationBestPractice = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $storageDuration = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $deletionProcedures = null;

    #[ORM\Column(length: 255, nullable: true, enumType: YesNo::class)]
    private ?YesNo $dataSelection = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $dataSelectionTimePoint = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $dataSelectionProcedures = null;

    public function getDataManagementPlan(): ?DataManagementPlan
    {
        return $this->dataManagementPlan;
    }

    public function setDataManagementPlan(?DataManagementPlan $dataManagementPlan): static
    {
        $this->dataManagementPlan = $dataManagementPlan;

        return $this;
    }

    public function getExistingDataReuse(): ?ExistingDataReuse
    {
        return $this->existingDataReuse;
    }

    public function setExistingDataReuse(?ExistingDataReuse $existingDataReuse): static
    {
        $this->existingDataReuse = $existingDataReuse;

        return $this;
    }

    public function getExistingDataCitation(): ?string
    {
        return $this->existingDataCitation;
    }

    public function setExistingDataCitation(?string $existingDataCitation): static
    {
        $this->existingDataCitation = $existingDataCitation;

        return $this;
    }

    public function getExistingDataRelevance(): ?string
    {
        return $this->existingDataRelevance;
    }

    public function setExistingDataRelevance(?string $existingDataRelevance): static
    {
        $this->existingDataRelevance = $existingDataRelevance;

        return $this;
    }

    public function getExistingDataIntegration(): ?string
    {
        return $this->existingDataIntegration;
    }

    public function setExistingDataIntegration(?string $existingDataIntegration): static
    {
        $this->existingDataIntegration = $existingDataIntegration;

        return $this;
    }

    public function getResearchMethod(): ?array
    {
        return $this->researchMethod;
    }

    public function setResearchMethod(?array $researchMethod): static
    {
        $this->researchMethod = $researchMethod;

        return $this;
    }

    public function getResearchMethodOtherDescription(): ?string
    {
        return $this->researchMethodOtherDescription;
    }

    public function setResearchMethodOtherDescription(?string $researchMethodOtherDescription): static
    {
        $this->researchMethodOtherDescription = $researchMethodOtherDescription;

        return $this;
    }

    public function getDataCollectionReproducibility(): ?string
    {
        return $this->dataCollectionReproducibility;
    }

    public function setDataCollectionReproducibility(?string $dataCollectionReproducibility): static
    {
        $this->dataCollectionReproducibility = $dataCollectionReproducibility;

        return $this;
    }

    public function getCollectionMode(): ?array
    {
        return $this->collectionMode;
    }

    public function setCollectionMode(?array $collectionMode): static
    {
        $this->collectionMode = $collectionMode;

        return $this;
    }

    public function getCollectionApparatus(): ?string
    {
        return $this->collectionApparatus;
    }

    public function setCollectionApparatus(?string $collectionApparatus): static
    {
        $this->collectionApparatus = $collectionApparatus;

        return $this;
    }

    public function getCollectionModeOtherDescription(): ?string
    {
        return $this->collectionModeOtherDescription;
    }

    public function setCollectionModeOtherDescription(?string $collectionModeOtherDescription): static
    {
        $this->collectionModeOtherDescription = $collectionModeOtherDescription;

        return $this;
    }

    public function getResearchDesign(): ?ResearchDesign
    {
        return $this->researchDesign;
    }

    public function setResearchDesign(?ResearchDesign $researchDesign): static
    {
        $this->researchDesign = $researchDesign;

        return $this;
    }

    public function getDataCollectorTraining(): ?string
    {
        return $this->dataCollectorTraining;
    }

    public function setDataCollectorTraining(?string $dataCollectorTraining): static
    {
        $this->dataCollectorTraining = $dataCollectorTraining;

        return $this;
    }

    public function getConstructsMultipleMeasurement(): ?string
    {
        return $this->constructsMultipleMeasurement;
    }

    public function setConstructsMultipleMeasurement(?string $constructsMultipleMeasurement): static
    {
        $this->constructsMultipleMeasurement = $constructsMultipleMeasurement;

        return $this;
    }

    public function getQualityAssuranceOtherDescription(): ?string
    {
        return $this->qualityAssuranceOtherDescription;
    }

    public function setQualityAssuranceOtherDescription(?string $qualityAssuranceOtherDescription): static
    {
        $this->qualityAssuranceOtherDescription = $qualityAssuranceOtherDescription;

        return $this;
    }

    public function getFileFormats(): ?string
    {
        return $this->fileFormats;
    }

    public function setFileFormats(?string $fileFormats): static
    {
        $this->fileFormats = $fileFormats;

        return $this;
    }

    public function getDataPreservationWorkingCopy(): ?YesNo
    {
        return $this->dataPreservationWorkingCopy;
    }

    public function setDataPreservationWorkingCopy(?YesNo $dataPreservationWorkingCopy): static
    {
        $this->dataPreservationWorkingCopy = $dataPreservationWorkingCopy;

        return $this;
    }

    public function getDataPreservationGoodScientificPracticeProof(): ?YesNo
    {
        return $this->dataPreservationGoodScientificPracticeProof;
    }

    public function setDataPreservationGoodScientificPracticeProof(?YesNo $dataPreservationGoodScientificPracticeProof): static
    {
        $this->dataPreservationGoodScientificPracticeProof = $dataPreservationGoodScientificPracticeProof;

        return $this;
    }

    public function getDataPreservationReproducibility(): ?YesNo
    {
        return $this->dataPreservationReproducibility;
    }

    public function setDataPreservationReproducibility(?YesNo $dataPreservationReproducibility): static
    {
        $this->dataPreservationReproducibility = $dataPreservationReproducibility;

        return $this;
    }

    public function getDataPreservationLegalObligations(): ?YesNo
    {
        return $this->dataPreservationLegalObligations;
    }

    public function setDataPreservationLegalObligations(?YesNo $dataPreservationLegalObligations): static
    {
        $this->dataPreservationLegalObligations = $dataPreservationLegalObligations;

        return $this;
    }

    public function getDataPreservationBestPractice(): ?YesNo
    {
        return $this->dataPreservationBestPractice;
    }

    public function setDataPreservationBestPractice(?YesNo $dataPreservationBestPractice): static
    {
        $this->dataPreservationBestPractice = $dataPreservationBestPractice;

        return $this;
    }

    public function getStorageDuration(): ?string
    {
        return $this->storageDuration;
    }

    public function setStorageDuration(?string $storageDuration): static
    {
        $this->storageDuration = $storageDuration;

        return $this;
    }

    public function getDeletionProcedures(): ?string
    {
        return $this->deletionProcedures;
    }

    public function setDeletionProcedures(?string $deletionProcedures): static
    {
        $this->deletionProcedures = $deletionProcedures;

        return $this;
    }

    public function getDataSelection(): ?YesNo
    {
        return $this->dataSelection;
    }

    public function setDataSelection(?YesNo $dataSelection): static
    {
        $this->dataSelection = $dataSelection;

        return $this;
    }

    public function getDataSelectionTimePoint(): ?string
    {
        return $this->dataSelectionTimePoint;
    }

    public function setDataSelectionTimePoint(?string $dataSelectionTimePoint): static
    {
        $this->dataSelectionTimePoint = $dataSelectionTimePoint;

        return $this;
    }

    public function getDataSelectionProcedures(): ?string
    {
        return $this->dataSelectionProcedures;
    }

    public function setDataSelectionProcedures(?string $dataSelectionProcedures): static
    {
        $this->dataSelectionProcedures = $dataSelectionProcedures;

        return $this;
    }
}
