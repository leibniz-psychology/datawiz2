<?php


namespace App\Domain\Model\Study;


use App\Domain\Definition\MetaDataValuable;
use App\Domain\Model\Administration\UuidEntity;
use App\Questionnaire\Questionable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class MethodMetaDataGroup  extends UuidEntity implements MetaDataValuable, Questionable
{
    /**
     * One basic Information section has One Experiment.
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="methodMetaDataGroup")
     */
    protected $experiment;
    use ExperimentRelatable;

    public static function getImplementedMetaData(): array
    {
        // TODO: Implement getImplementedMetaData() method.
    }

    public function getFormTypeForEntity(): string
    {
        // TODO: Implement getFormTypeForEntity() method.
    }
}