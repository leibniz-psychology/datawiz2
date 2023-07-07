<?php

namespace App\Entity\Study;

use App\Entity\Administration\UuidEntity;
use App\Entity\Constant\ReviewDataDictionary;
use App\Form\SampleType;
use App\Service\Questionnaire\Questionable;
use App\Service\Review\Reviewable;
use App\Service\Review\ReviewDataCollectable;
use App\Service\Review\ReviewValidator;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Table(name: 'experiment_sample')]
#[ORM\Entity]
class SampleMetaDataGroup extends UuidEntity implements Questionable, Reviewable
{
    /**
     * One Sample section has One Experiment.
     */
    #[ORM\OneToOne(inversedBy: 'sampleMetaDataGroup')]
    protected ?Experiment $experiment = null;

    #[ORM\Column(type: 'text', length: 1500, nullable: true)]
    #[SerializedName('participants')]
    #[Groups(['study'])]
    private ?string $participants = null;

    #[ORM\Column(type: 'json', length: 1500, nullable: true)]
    #[SerializedName('inclusion_criteria')]
    #[Groups(['study'])]
    private ?array $inclusion_criteria = null;

    #[ORM\Column(type: 'json', length: 1500, nullable: true)]
    #[SerializedName('exclusion_criteria')]
    #[Groups(['study'])]
    private ?array $exclusion_criteria = null;

    #[ORM\Column(type: 'json', length: 1500, nullable: true)]
    #[SerializedName('population')]
    #[Groups(['study'])]
    private ?array $population = null;

    #[ORM\Column(type: 'text', length: 1500, nullable: true)]
    #[SerializedName('sampling_method')]
    #[Groups(['study'])]
    private ?string $sampling_method = null;

    #[ORM\Column(type: 'text', length: 1500, nullable: true)]
    #[SerializedName('other_sampling_method')]
    #[Groups(['study'])]
    private ?string $other_sampling_method = null;

    #[ORM\Column(type: 'text', length: 1500, nullable: true)]
    #[SerializedName('sample_size')]
    #[Groups(['study'])]
    private ?string $sample_size = null;

    #[ORM\Column(type: 'text', length: 1500, nullable: true)]
    #[SerializedName('power_analysis')]
    #[Groups(['study'])]
    private ?string $power_analysis = null;

    public function getReviewCollection(): array
    {
        return [
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::PARTICIPANTS,
                [$this->getParticipants()],
                ReviewValidator::validateSingleValue($this->getParticipants())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::POPULATION,
                $this->getPopulation(),
                ReviewValidator::validateArrayValues($this->getPopulation())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::INCLUSION,
                $this->getInclusionCriteria(),
                ReviewValidator::validateArrayValues($this->getInclusionCriteria())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::EXCLUSION,
                $this->getExclusionCriteria(),
                ReviewValidator::validateArrayValues($this->getExclusionCriteria())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::SAMPLING,
                [$this->getSamplingMethod() !== 'Other' ? $this->getSamplingMethod() : $this->getOtherSamplingMethod()],
                ($this->getSamplingMethod() !== 'Other' && ReviewValidator::validateSingleValue($this->getSamplingMethod()))
                || ($this->getSamplingMethod() === 'Other' && ReviewValidator::validateSingleValue($this->getOtherSamplingMethod()))
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::SAMPLE_SIZE,
                [$this->getSampleSize()],
                ReviewValidator::validateSingleValue($this->getSampleSize())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::POWER_ANALYSIS,
                [$this->getPowerAnalysis()],
                ReviewValidator::validateSingleValue($this->getPowerAnalysis())
            ),
        ];
    }

    public function getFormTypeForEntity(): string
    {
        return SampleType::class;
    }

    public function getParticipants(): ?string
    {
        return $this->participants;
    }

    public function setParticipants(?string $participants): void
    {
        $this->participants = $participants;
    }

    public function getInclusionCriteria(): ?array
    {
        return $this->inclusion_criteria;
    }

    public function setInclusionCriteria(?array $inclusion_criteria): void
    {
        $this->inclusion_criteria = $inclusion_criteria == null ? null : array_values($inclusion_criteria);
    }

    public function getExclusionCriteria(): ?array
    {
        return $this->exclusion_criteria;
    }

    public function setExclusionCriteria(?array $exclusion_criteria): void
    {
        $this->exclusion_criteria = $exclusion_criteria == null ? null : array_values($exclusion_criteria);
    }

    public function getPopulation(): ?array
    {
        return $this->population;
    }

    public function setPopulation(?array $population): void
    {
        $this->population = $population == null ? null : array_values($population);
    }

    public function getSamplingMethod(): ?string
    {
        return $this->sampling_method;
    }

    public function setSamplingMethod(?string $sampling_method): void
    {
        $this->sampling_method = $sampling_method;
    }

    public function getOtherSamplingMethod(): ?string
    {
        return $this->other_sampling_method;
    }

    public function setOtherSamplingMethod(?string $other_sampling_method): void
    {
        $this->other_sampling_method = $other_sampling_method;
    }

    public function getSampleSize(): ?string
    {
        return $this->sample_size;
    }

    public function setSampleSize(?string $sample_size): void
    {
        $this->sample_size = $sample_size;
    }

    public function getPowerAnalysis(): ?string
    {
        return $this->power_analysis;
    }

    public function setPowerAnalysis(?string $power_analysis): void
    {
        $this->power_analysis = $power_analysis;
    }

    public function getExperiment(): Experiment
    {
        return $this->experiment;
    }

    public function setExperiment(Experiment $experiment): void
    {
        $this->experiment = $experiment;
    }
}
