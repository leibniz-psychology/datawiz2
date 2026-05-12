<?php

namespace App\Entity\Study;

use App\Entity\Administration\UuidEntity;
use App\Enum\Study\ParticipantGroup;
use App\Enum\Study\SampleAnalysisUnit;
use App\Enum\Study\SamplingMethod;
use App\Repository\SampleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ORM\Table(name: 'experiment_sample')]
#[ORM\Entity(repositoryClass: SampleRepository::class)]
class SampleMetaDataGroup extends UuidEntity
{
    /**
     * One Sample section has One Experiment.
     */
    #[ORM\OneToOne(inversedBy: 'sampleMetaDataGroup', cascade: ['persist', 'remove'])]
    protected ?Experiment $experiment = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    #[SerializedName('participant_minimum_age')]
    #[Groups(['study'])]
    private ?int $participantMinAge = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    #[SerializedName('participant_maximum_age')]
    #[Groups(['study'])]
    private ?int $participantMaxAge = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('participant_maximum_age_unlimited')]
    #[Groups(['study'])]
    private ?bool $participantMaxAgeUnlimited = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true, enumType: ParticipantGroup::class)]
    #[SerializedName('participant_groups')]
    #[Groups('study')]
    private ?array $participantGroups = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('participant_groups_other_description')]
    #[Groups(['study'])]
    private ?string $participantGroupsOtherDescription = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('population')]
    #[Groups(['study'])]
    private ?array $population = null;

    #[ORM\Column(nullable: true, enumType: SamplingMethod::class)]
    #[SerializedName('sampling_method')]
    #[Groups(['study'])]
    private ?SamplingMethod $samplingMethod = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('sampling_method_other_description')]
    #[Groups(['study'])]
    private ?string $samplingMethodOtherDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('recruiting')]
    #[Groups(['study'])]
    private ?string $recruiting = null;

    #[ORM\Column(type: Types::TEXT, length: 1500, nullable: true)]
    #[SerializedName('sample_size')]
    #[Groups(['study'])]
    private ?string $sampleSize = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('intended_sample_size')]
    #[Groups(['study'])]
    private ?string $intendedSampleSize = null;

    #[ORM\Column(type: Types::TEXT, length: 1500, nullable: true)]
    #[SerializedName('power_analysis')]
    #[Groups(['study'])]
    private ?string $powerAnalysis = null;

    #[ORM\Column(nullable: true, enumType: SampleAnalysisUnit::class)]
    #[SerializedName('unit_of_analysis')]
    #[Groups(['study'])]
    private ?SampleAnalysisUnit $unitOfAnalysis = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('unit_of_analysis_other_description')]
    #[Groups(['study'])]
    private ?string $unitOfAnalysisOtherDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('multilevel_structure')]
    #[Groups(['study'])]
    private ?string $multilevelStructure = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('sex')]
    #[Groups(['study'])]
    private ?string $sex = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('age')]
    #[Groups(['study'])]
    private ?string $age = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('special_groups')]
    #[Groups(['study'])]
    private ?string $specialGroups = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('country')]
    #[Groups(['study'])]
    private ?string $country = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('city')]
    #[Groups(['study'])]
    private ?string $city = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('region')]
    #[Groups(['study'])]
    private ?string $region = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('missing_values')]
    #[Groups(['study'])]
    private ?string $missingValues = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('return_dropout')]
    #[Groups(['study'])]
    private ?string $returnDropout = null;

    public function getParticipantMinAge(): ?int
    {
        return $this->participantMinAge;
    }

    public function setParticipantMinAge(?int $participantMinAge): void
    {
        $this->participantMinAge = $participantMinAge;
    }

    public function getParticipantMaxAge(): ?int
    {
        return $this->participantMaxAge;
    }

    public function setParticipantMaxAge(?int $participantMaxAge): void
    {
        $this->participantMaxAge = $participantMaxAge;
    }

    public function getParticipantMaxAgeUnlimited(): ?bool
    {
        return $this->participantMaxAgeUnlimited;
    }

    public function setParticipantMaxAgeUnlimited(?bool $participantMaxAgeUnlimited): void
    {
        $this->participantMaxAgeUnlimited = $participantMaxAgeUnlimited;
    }

    public function getParticipantGroups(): ?array
    {
        return $this->participantGroups;
    }

    public function setParticipantGroups(?array $participantGroups): void
    {
        $this->participantGroups = $participantGroups == null ? null : array_values($participantGroups);
    }

    public function getParticipantGroupsOtherDescription(): ?string
    {
        return $this->participantGroupsOtherDescription;
    }

    public function setParticipantGroupsOtherDescription(?string $participantGroupsOtherDescription): void
    {
        $this->participantGroupsOtherDescription = $participantGroupsOtherDescription;
    }

    public function getPopulation(): ?array
    {
        return $this->population;
    }

    public function setPopulation(?array $population): void
    {
        $this->population = $population == null ? null : array_values($population);
    }

    public function getSamplingMethod(): ?SamplingMethod
    {
        return $this->samplingMethod;
    }

    public function setSamplingMethod(?SamplingMethod $samplingMethod): static
    {
        $this->samplingMethod = $samplingMethod;

        return $this;
    }

    public function getSamplingMethodOtherDescription(): ?string
    {
        return $this->samplingMethodOtherDescription;
    }

    public function setSamplingMethodOtherDescription(?string $samplingMethodOtherDescription): static
    {
        $this->samplingMethodOtherDescription = $samplingMethodOtherDescription;

        return $this;
    }

    public function getRecruiting(): ?string
    {
        return $this->recruiting;
    }

    public function setRecruiting(?string $recruiting): static
    {
        $this->recruiting = $recruiting;

        return $this;
    }

    public function getSampleSize(): ?string
    {
        return $this->sampleSize;
    }

    public function setSampleSize(?string $sampleSize): void
    {
        $this->sampleSize = $sampleSize;
    }

    public function getPowerAnalysis(): ?string
    {
        return $this->powerAnalysis;
    }

    public function setPowerAnalysis(?string $powerAnalysis): void
    {
        $this->powerAnalysis = $powerAnalysis;
    }

    public function getExperiment(): Experiment
    {
        return $this->experiment;
    }

    public function setExperiment(Experiment $experiment): void
    {
        $this->experiment = $experiment;
    }

    public function getIntendedSampleSize(): ?string
    {
        return $this->intendedSampleSize;
    }

    public function setIntendedSampleSize(?string $intendedSampleSize): static
    {
        $this->intendedSampleSize = $intendedSampleSize;

        return $this;
    }

    public function getUnitOfAnalysis(): ?SampleAnalysisUnit
    {
        return $this->unitOfAnalysis;
    }

    public function setUnitOfAnalysis(?SampleAnalysisUnit $unitOfAnalysis): static
    {
        $this->unitOfAnalysis = $unitOfAnalysis;

        return $this;
    }

    public function getUnitOfAnalysisOtherDescription(): ?string
    {
        return $this->unitOfAnalysisOtherDescription;
    }

    public function setUnitOfAnalysisOtherDescription(?string $unitOfAnalysisOtherDescription): static
    {
        $this->unitOfAnalysisOtherDescription = $unitOfAnalysisOtherDescription;

        return $this;
    }

    public function getMultilevelStructure(): ?string
    {
        return $this->multilevelStructure;
    }

    public function setMultilevelStructure(?string $multilevelStructure): static
    {
        $this->multilevelStructure = $multilevelStructure;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(?string $sex): static
    {
        $this->sex = $sex;

        return $this;
    }

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(?string $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getSpecialGroups(): ?string
    {
        return $this->specialGroups;
    }

    public function setSpecialGroups(?string $specialGroups): static
    {
        $this->specialGroups = $specialGroups;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): static
    {
        $this->region = $region;

        return $this;
    }

    public function getMissingValues(): ?string
    {
        return $this->missingValues;
    }

    public function setMissingValues(?string $missingValues): static
    {
        $this->missingValues = $missingValues;

        return $this;
    }

    public function getReturnDropout(): ?string
    {
        return $this->returnDropout;
    }

    public function setReturnDropout(?string $returnDropout): static
    {
        $this->returnDropout = $returnDropout;

        return $this;
    }
}
