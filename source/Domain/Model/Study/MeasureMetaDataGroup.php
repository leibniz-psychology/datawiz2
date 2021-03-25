<?php


namespace App\Domain\Model\Study;


use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Definition\MetaDataValuable;
use App\Domain\Definition\Study\Apparaturable;
use App\Domain\Definition\Study\Measureable;
use App\Domain\Model\Administration\UuidEntity;
use App\Questionnaire\Forms\MeasureType;
use App\Questionnaire\Questionable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class MeasureMetaDataGroup extends UuidEntity implements MetaDataValuable, Questionable
{
    /**
     * One basic Information section has One Experiment.
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="measureMetaDataGroup")
     */
    protected $experiment;
    use ExperimentRelatable;

    use Measureable;
    use Apparaturable;

    public static function getImplementedMetaData(): array
    {
        return [
            MetaDataDictionary::MEASURES,
            MetaDataDictionary::APPARATUS
        ];
    }

    public function getFormTypeForEntity(): string
    {
        return MeasureType::class;
    }
}