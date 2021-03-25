<?php

namespace App\Domain\Model\Study;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Definition\MetaDataValuable;
use App\Domain\Definition\Study\Hypothesable;
use App\Domain\Definition\Study\Objectivable;
use App\Domain\Model\Administration\UuidEntity;
use App\Questionnaire\Forms\TheoryType;
use App\Questionnaire\Questionable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class TheoryMetaDataGroup extends UuidEntity implements MetaDataValuable, Questionable
{
    /**
     * One Theory section has One Experiment.
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="theoryMetaDataGroup")
     */
    protected $experiment;

    use ExperimentRelatable;

    use Objectivable;
    use Hypothesable;

    public static function getImplementedMetaData(): array
    {
        return [
            MetaDataDictionary::OBJECTIVE,
            MetaDataDictionary::HYPOTHESIS,
        ];
    }

    public function getFormTypeForEntity(): string
    {
        return TheoryType::class;
    }
}
