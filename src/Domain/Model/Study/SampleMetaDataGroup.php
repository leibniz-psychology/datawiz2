<?php

namespace App\Domain\Model\Study;

use App\Domain\Definition\ReviewDataDictionary;
use App\Domain\Model\Administration\UuidEntity;
use App\Questionnaire\Forms\SampleType;
use App\Questionnaire\Questionable;
use App\Review\Reviewable;
use App\Review\ReviewDataCollectable;
use App\Review\ReviewValidator;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity()
 * @ORM\Table(name="experiment_sample")
 */
class SampleMetaDataGroup extends UuidEntity implements Questionable, Reviewable
{

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     * @SerializedName("participants")
     * @Groups({"study"})
     */
    private ?string $participants = null;

    /**
     * @ORM\Column(type="array", length=1500, nullable=true)
     * @SerializedName("inclusion_criteria")
     * @Groups({"study"})
     */
    private ?array $inclusion_criteria = null;

    /**
     * @ORM\Column(type="array", length=1500, nullable=true)
     * @SerializedName("exclusion_criteria")
     * @Groups({"study"})
     */
    private ?array $exclusion_criteria = null;

    /**
     * @ORM\Column(type="array", length=1500, nullable=true)
     * @SerializedName("population")
     * @Groups({"study"})
     */
    private ?array $population = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     * @SerializedName("sampling_method")
     * @Groups({"study"})
     */
    private ?string $sampling_method = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     * @SerializedName("other_sampling_method")
     * @Groups({"study"})
     */
    private ?string $other_sampling_method = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     * @SerializedName("sample_size")
     * @Groups({"study"})
     */
    private ?string $sample_size = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     * @SerializedName("power_analysis")
     * @Groups({"study"})
     */
    private ?string $power_analysis = null;

    /**
     * One Sample section has One Experiment.
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="sampleMetaDataGroup")
     */
    protected Experiment $experiment;

    public function getReviewCollection(): array
    {
        return [
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::PARTICIPANTS,
                [$this->getParticipants()],
                null != ReviewDataDictionary::PARTICIPANTS['errorLevel'] && ReviewValidator::validateSingleValue($this->getParticipants())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::POPULATION,
                $this->getPopulation(),
                null != ReviewDataDictionary::POPULATION['errorLevel'] && ReviewValidator::validateArrayValues($this->getPopulation())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::INCLUSION,
                $this->getInclusionCriteria(),
                null != ReviewDataDictionary::INCLUSION['errorLevel'] && ReviewValidator::validateArrayValues($this->getInclusionCriteria())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::EXCLUSION,
                $this->getExclusionCriteria(),
                null != ReviewDataDictionary::EXCLUSION['errorLevel'] && ReviewValidator::validateArrayValues($this->getExclusionCriteria())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::SAMPLING,
                ["Other" !== $this->getSamplingMethod() ? $this->getSamplingMethod() : $this->getOtherSamplingMethod()],
                null != ReviewDataDictionary::SAMPLING['errorLevel'] &&
                ("Other" !== $this->getSamplingMethod() && ReviewValidator::validateSingleValue($this->getSamplingMethod())) ||
                ("Other" === $this->getSamplingMethod() && ReviewValidator::validateSingleValue($this->getOtherSamplingMethod()))
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::SAMPLE_SIZE,
                [$this->getSampleSize()],
                null != ReviewDataDictionary::SAMPLE_SIZE['errorLevel'] && ReviewValidator::validateSingleValue($this->getSampleSize())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::POWER_ANALYSIS,
                [$this->getPowerAnalysis()],
                null != ReviewDataDictionary::POWER_ANALYSIS['errorLevel'] && ReviewValidator::validateSingleValue($this->getPowerAnalysis())
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
        $this->inclusion_criteria = null == $inclusion_criteria ? null : array_values($inclusion_criteria);
    }

    public function getExclusionCriteria(): ?array
    {
        return $this->exclusion_criteria;
    }

    public function setExclusionCriteria(?array $exclusion_criteria): void
    {
        $this->exclusion_criteria = null == $exclusion_criteria ? null : array_values($exclusion_criteria);
    }

    public function getPopulation(): ?array
    {
        return $this->population;
    }

    public function setPopulation(?array $population): void
    {
        $this->population = null == $population ? null : array_values($population);
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
