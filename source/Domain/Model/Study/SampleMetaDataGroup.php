<?php

namespace App\Domain\Model\Study;


use App\Domain\Definition\MetaDataValuable;
use App\Domain\Model\Administration\UuidEntity;
use App\Questionnaire\Forms\SampleType;
use App\Questionnaire\Questionable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class SampleMetaDataGroup extends UuidEntity implements MetaDataValuable, Questionable
{
    /**
     * One Sample section has One Experiment.
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="sampleMetaDataGroup")
     */
    protected $experiment;

    use ExperimentRelatable;

    public static function getImplementedMetaData(): array
    {
        return array();
    }

    public function getFormTypeForEntity(): string
    {
        return SampleType::class;
    }
}
