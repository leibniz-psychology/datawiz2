<?php

namespace App\Domain\Model\Study;


use App\Domain\Model\Administration\UuidEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class SampleMetaDataGroup extends UuidEntity
{
    /**
     * One Sample section has One Experiment.
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="sampleMetaDataGroup")
     */
    protected $experiment;

    use ExperimentRelatable;
}
