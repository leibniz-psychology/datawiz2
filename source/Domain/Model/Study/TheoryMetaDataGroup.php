<?php

namespace App\Domain\Model\Study;

use App\Domain\Model\Administration\UuidEntity;
use App\Questionnaire\Forms\TheoryType;
use App\Questionnaire\Questionable;
use App\Review\Reviewable;
use App\Review\ReviewDataCollectable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="experiment_theory")
 */
class TheoryMetaDataGroup extends UuidEntity implements Questionable, Reviewable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private ?string $objective = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private ?string $hypothesis = null;


    /**
     * One Theory section has One Experiment.
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="theoryMetaDataGroup")
     */
    protected Experiment $experiment;


    public function getReviewCollection()
    {
        return [
            ReviewDataCollectable::createFrom('Objectives', [$this->getObjective()]),
            ReviewDataCollectable::createFrom('Hypotheses', [$this->getHypothesis()]),
        ];
    }

    public function getFormTypeForEntity(): string
    {
        return TheoryType::class;
    }

    /**
     * @return string|null
     */
    public function getObjective(): ?string
    {
        return $this->objective;
    }

    /**
     * @param string|null $objective
     */
    public function setObjective(?string $objective): void
    {
        $this->objective = $objective;
    }

    /**
     * @return string|null
     */
    public function getHypothesis(): ?string
    {
        return $this->hypothesis;
    }

    /**
     * @param string|null $hypothesis
     */
    public function setHypothesis(?string $hypothesis): void
    {
        $this->hypothesis = $hypothesis;
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
