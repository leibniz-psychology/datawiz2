<?php

namespace App\Domain\Model\Study;

use App\Domain\Definition\Study\Assignable;
use App\Domain\Definition\Study\Criteriable;
use App\Domain\Definition\Study\Populatable;
use App\Domain\Definition\Study\Powerable;
use App\Domain\Definition\Study\SampleSizable;
use App\Domain\Definition\Study\SamplingMethodable;
use App\Domain\Model\Administration\UuidEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class SampleMetaDataGroup extends UuidEntity implements Criteriable, Populatable, SamplingMethodable, Assignable, SampleSizable, Powerable
{
    /**
     * One Sample section has One Experiment.
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="sampleMetaDataGroup")
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
     * @param mixed $experiment
     */
    public function setExperiment(Experiment $experiment): void
    {
        $this->experiment = $experiment;
    }
}
