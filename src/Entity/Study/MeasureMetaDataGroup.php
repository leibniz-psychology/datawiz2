<?php

namespace App\Entity\Study;

use App\Entity\Administration\UuidEntity;
use App\Entity\Constant\ReviewDataDictionary;
use App\Enum\Study\CollectionMode;
use App\Enum\Study\DataDigitization;
use App\Enum\Study\RecordType;
use App\Repository\MeasureRepository;
use App\Service\Review\Reviewable;
use App\Service\Review\ReviewDataCollectable;
use App\Service\Review\ReviewValidator;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ORM\Table(name: 'experiment_measure')]
#[ORM\Entity(repositoryClass: MeasureRepository::class)]
class MeasureMetaDataGroup extends UuidEntity implements Reviewable
{
    /**
     * One basic Information section has One Experiment.
     */
    #[ORM\OneToOne(inversedBy: 'measureMetaDataGroup', cascade: ['persist', 'remove'])]
    protected ?Experiment $experiment = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    #[SerializedName('data_collection_start')]
    #[Groups(['study'])]
    private ?\DateTimeImmutable $dataCollectionStart = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    #[SerializedName('data_collection_end')]
    #[Groups(['study'])]
    private ?\DateTimeImmutable $dataCollectionEnd = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true, enumType: CollectionMode::class)]
    #[SerializedName('collection_mode')]
    #[Groups(['study'])]
    private ?array $collectionMode = null;

    #[ORM\Column(length: 1500, nullable: true)]
    #[SerializedName('apparatus')]
    #[Groups(['study'])]
    private ?array $apparatus = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('collection_mode_other_description')]
    #[Groups(['study'])]
    private ?string $collectionModeOtherDescription = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true, enumType: RecordType::class)]
    #[SerializedName('original_record_type')]
    #[Groups(['study'])]
    private ?array $originalRecordType = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('original_record_type_other_description')]
    #[Groups(['study'])]
    private ?string $originalRecordTypeOtherDescription = null;

    #[ORM\Column(nullable: true, enumType: DataDigitization::class)]
    #[SerializedName('raw_data_digitization')]
    #[Groups(['study'])]
    private ?DataDigitization $rawDataDigitization = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('raw_data_digitization_description')]
    #[Groups(['study'])]
    private ?string $rawDataDigitizationDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('special_circumstances')]
    #[Groups(['study'])]
    private ?string $specialCircumstances = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('raw_data_transformation')]
    #[Groups(['study'])]
    private ?string $rawDataTransformation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('quality_indicators')]
    #[Groups(['study'])]
    private ?string $qualityIndicators = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('limitations')]
    #[Groups(['study'])]
    private ?string $limitations = null;

    public function getReviewCollection(): array
    {
        return [
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::APPARATUS,
                $this->getApparatus(),
                ReviewValidator::validateArrayValues($this->getApparatus())
            ),
        ];
    }

    public function getExperiment(): Experiment
    {
        return $this->experiment;
    }

    public function setExperiment(Experiment $experiment): void
    {
        $this->experiment = $experiment;
    }

    public function getDataCollectionStart(): ?\DateTimeImmutable
    {
        return $this->dataCollectionStart;
    }

    public function setDataCollectionStart(?\DateTimeImmutable $dataCollectionStart): static
    {
        $this->dataCollectionStart = $dataCollectionStart;

        return $this;
    }

    public function getDataCollectionEnd(): ?\DateTimeImmutable
    {
        return $this->dataCollectionEnd;
    }

    public function setDataCollectionEnd(?\DateTimeImmutable $dataCollectionEnd): static
    {
        $this->dataCollectionEnd = $dataCollectionEnd;

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

    public function getApparatus(): ?array
    {
        return $this->apparatus;
    }

    public function setApparatus(?array $apparatus): void
    {
        $this->apparatus = $apparatus == null ? null : array_values($apparatus);
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

    /**
     * @return null|RecordType[]
     */
    public function getOriginalRecordType(): ?array
    {
        return $this->originalRecordType;
    }

    public function setOriginalRecordType(?array $originalRecordType): static
    {
        $this->originalRecordType = $originalRecordType;

        return $this;
    }

    public function getOriginalRecordTypeOtherDescription(): ?string
    {
        return $this->originalRecordTypeOtherDescription;
    }

    public function setOriginalRecordTypeOtherDescription(?string $originalRecordTypeOtherDescription): static
    {
        $this->originalRecordTypeOtherDescription = $originalRecordTypeOtherDescription;

        return $this;
    }

    public function getRawDataDigitization(): ?DataDigitization
    {
        return $this->rawDataDigitization;
    }

    public function setRawDataDigitization(?DataDigitization $rawDataDigitization): static
    {
        $this->rawDataDigitization = $rawDataDigitization;

        return $this;
    }

    public function getRawDataDigitizationDescription(): ?string
    {
        return $this->rawDataDigitizationDescription;
    }

    public function setRawDataDigitizationDescription(?string $rawDataDigitizationDescription): static
    {
        $this->rawDataDigitizationDescription = $rawDataDigitizationDescription;

        return $this;
    }

    public function getSpecialCircumstances(): ?string
    {
        return $this->specialCircumstances;
    }

    public function setSpecialCircumstances(string $specialCircumstances): static
    {
        $this->specialCircumstances = $specialCircumstances;

        return $this;
    }

    public function getRawDataTransformation(): ?string
    {
        return $this->rawDataTransformation;
    }

    public function setRawDataTransformation(?string $rawDataTransformation): static
    {
        $this->rawDataTransformation = $rawDataTransformation;

        return $this;
    }

    public function getQualityIndicators(): ?string
    {
        return $this->qualityIndicators;
    }

    public function setQualityIndicators(?string $qualityIndicators): static
    {
        $this->qualityIndicators = $qualityIndicators;

        return $this;
    }

    public function getLimitations(): ?string
    {
        return $this->limitations;
    }

    public function setLimitations(?string $limitations): static
    {
        $this->limitations = $limitations;

        return $this;
    }
}
