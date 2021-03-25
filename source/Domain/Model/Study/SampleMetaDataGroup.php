<?php

namespace App\Domain\Model\Study;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Definition\MetaDataValuable;
use App\Domain\Definition\Study\ExclusionCriteriable;
use App\Domain\Definition\Study\InclusionCriteriable;
use App\Domain\Definition\Study\Populatable;
use App\Domain\Definition\Study\PowerAnalysiable;
use App\Domain\Definition\Study\SampleMethodable;
use App\Domain\Definition\Study\SampleSizeable;
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
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="sampleMetaDataGroup")
     */
    protected $experiment;

    use ExperimentRelatable;

    use InclusionCriteriable;
    use ExclusionCriteriable;
    use Populatable;
    use SampleMethodable;
    use SampleSizeable;
    use PowerAnalysiable;

    public static function getImplementedMetaData(): array
    {
        return [
            MetaDataDictionary::INCLUSION_CRITERIA,
            MetaDataDictionary::EXCLUSION_CRITERIA,
            MetaDataDictionary::POPULATION,
            MetaDataDictionary::SAMPLING_METHOD,
            MetaDataDictionary::SAMPLE_SIZE,
            MetaDataDictionary::POWER_ANALYSIS,
        ];
    }

    public function getFormTypeForEntity(): string
    {
        return SampleType::class;
    }
}
