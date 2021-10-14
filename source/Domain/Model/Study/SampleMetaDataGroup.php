<?php

namespace App\Domain\Model\Study;

use App\Domain\Model\Administration\UuidEntity;
use App\Questionnaire\Forms\SampleType;
use App\Questionnaire\Questionable;
use App\Review\Reviewable;
use App\Review\ReviewDataCollectable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="experiment_sample")
 */
class SampleMetaDataGroup extends UuidEntity implements Questionable, Reviewable
{

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private ?string $participants = null;

    /**
     * @ORM\Column(type="array", length=1500, nullable=true)
     */
    private ?array $inclusion_criteria = null;

    /**
     * @ORM\Column(type="array", length=1500, nullable=true)
     */
    private ?array $exclusion_criteria = null;

    /**
     * @ORM\Column(type="array", length=1500, nullable=true)
     */
    private ?array $population = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private ?string $sampling_method = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private ?string $other_sampling_method = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private ?string $sample_size = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private ?string $power_analysis = null;

    /**
     * One Sample section has One Experiment.
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="sampleMetaDataGroup")
     */
    protected Experiment $experiment;

    /**
     * @return array
     */
    public function getReviewCollection(): array
    {
        return [
            ReviewDataCollectable::createFrom('Participants', [$this->getParticipants()]),
            ReviewDataCollectable::createFrom('Popluation', $this->getPopulation()),
            ReviewDataCollectable::createFrom('Inclusion criteria', $this->getInclusionCriteria()),
            ReviewDataCollectable::createFrom('Exclusion criteria', $this->getExclusionCriteria()),
            ReviewDataCollectable::createFrom('Sampling Method', [$this->getSamplingMethod()]),
            ReviewDataCollectable::createFrom('Sample Size', [$this->getSampleSize()]),
            ReviewDataCollectable::createFrom('Power analysis', [$this->getPowerAnalysis()]),
        ];
    }

    /**
     * @return string
     */
    public function getFormTypeForEntity(): string
    {
        return SampleType::class;
    }

    /**
     * @return string|null
     */
    public function getParticipants(): ?string
    {
        return $this->participants;
    }

    /**
     * @param string|null $participants
     */
    public function setParticipants(?string $participants): void
    {
        $this->participants = $participants;
    }

    /**
     * @return string[]|null
     */
    public function getInclusionCriteria(): ?array
    {
        if ($this->inclusion_criteria === null) {
            $this->inclusion_criteria = array('');
        }

        return $this->inclusion_criteria;
    }

    /**
     * @param array|null $inclusion_criteria
     */
    public function setInclusionCriteria(?array $inclusion_criteria): void
    {
        $this->inclusion_criteria = null == $inclusion_criteria ?: array_values($inclusion_criteria);
    }

    /**
     * @return string[]|null
     */
    public function getExclusionCriteria(): ?array
    {
        if ($this->exclusion_criteria === null) {
            $this->exclusion_criteria = array('');
        }

        return $this->exclusion_criteria;
    }

    /**
     * @param array|null $exclusion_criteria
     */
    public function setExclusionCriteria(?array $exclusion_criteria): void
    {
        $this->exclusion_criteria = null == $exclusion_criteria ?: array_values($exclusion_criteria);
    }

    /**
     * @return string[]|null
     */
    public function getPopulation(): ?array
    {
        if ($this->population === null) {
            $this->population = array('');
        }

        return $this->population;
    }

    /**
     * @param array|null $population
     */
    public function setPopulation(?array $population): void
    {
        $this->population = null == $population ?: array_values($population);
    }

    /**
     * @return string|null
     */
    public function getSamplingMethod(): ?string
    {
        if ($this->sampling_method === "Others") {
            return $this->other_sampling_method;
        }

        return $this->sampling_method;
    }

    /**
     * @param string|null $sampling_method
     */
    public function setSamplingMethod(?string $sampling_method): void
    {
        $this->sampling_method = $sampling_method;
    }

    /**
     * @return string|null
     */
    public function getOtherSamplingMethod(): ?string
    {
        return $this->other_sampling_method;
    }

    /**
     * @param string|null $other_sampling_method
     */
    public function setOtherSamplingMethod(?string $other_sampling_method): void
    {
        $this->other_sampling_method = $other_sampling_method;
    }

    /**
     * @return string|null
     */
    public function getSampleSize(): ?string
    {
        return $this->sample_size;
    }

    /**
     * @param string|null $sample_size
     */
    public function setSampleSize(?string $sample_size): void
    {
        $this->sample_size = $sample_size;
    }

    /**
     * @return string|null
     */
    public function getPowerAnalysis(): ?string
    {
        return $this->power_analysis;
    }

    /**
     * @param string|null $power_analysis
     */
    public function setPowerAnalysis(?string $power_analysis): void
    {
        $this->power_analysis = $power_analysis;
    }

    /**
     * @return Experiment
     */
    public function getExperiment(): Experiment
    {
        return $this->experiment;
    }

    /**
     * @param Experiment $experiment
     */
    public function setExperiment(Experiment $experiment): void
    {
        $this->experiment = $experiment;
    }
}
