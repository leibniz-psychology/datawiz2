<?php

namespace App\Domain\Model\Study;

use App\Domain\Model\Administration\UuidEntity;
use App\Questionnaire\Forms\MeasureType;
use App\Questionnaire\Questionable;
use App\Review\Reviewable;
use App\Review\ReviewDataCollectable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="experiment_measure")
 */
class MeasureMetaDataGroup extends UuidEntity implements Questionable, Reviewable
{

    /**
     * @ORM\Column(type="array", length=1500, nullable=true)
     * @var $measures array|null
     */
    private ?array $measures = null;

    /**
     * @ORM\Column(type="array", length=1500, nullable=true)
     * @var $apparatus array|null
     */
    private ?array $apparatus = null;

    /**
     * One basic Information section has One Experiment.
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="measureMetaDataGroup")
     */
    protected Experiment $experiment;

    /**
     * @return array
     */
    public function getReviewCollection(): array
    {
        return [
            ReviewDataCollectable::createFrom('Measures', $this->getMeasures()),
            ReviewDataCollectable::createFrom('Apparatus', $this->getApparatus()),
        ];
    }

    /**
     * @return string
     */
    public function getFormTypeForEntity(): string
    {
        return MeasureType::class;
    }

    /**
     * @return array|null
     */
    public function getMeasures(): ?array
    {
        if ($this->measures === null) {
            $this->measures = array('');
        }

        return $this->measures;
    }

    /**
     * @param array|null $measures
     */
    public function setMeasures(?array $measures): void
    {
        $this->measures = null == $measures ? null : array_values($measures);
    }

    /**
     * @return array|null
     */
    public function getApparatus(): ?array
    {
        if ($this->apparatus === null) {
            $this->apparatus = array('');
        }

        return $this->apparatus;
    }

    /**
     * @param array|null $apparatus
     */
    public function setApparatus(?array $apparatus): void
    {
        $this->apparatus = null == $apparatus ? null : array_values($apparatus);
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
