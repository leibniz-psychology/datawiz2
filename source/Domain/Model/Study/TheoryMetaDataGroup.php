<?php

namespace App\Domain\Model\Study;

use App\Domain\Definition\Study\Hypothesiable;
use App\Domain\Definition\Study\Objectivable;
use App\Domain\Model\Administration\UuidEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class TheoryMetaDataGroup extends UuidEntity implements Objectivable, Hypothesiable
{
    /**
     * One Theory section has One Experiment.
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="theoryMetaDataGroup")
     * @ORM\JoinColumn(name="experiment_uuid", referencedColumnName="uuid")
     */
    private $experiment;

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
