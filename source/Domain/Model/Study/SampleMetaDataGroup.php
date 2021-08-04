<?php

namespace App\Domain\Model\Study;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Definition\MetaDataValuable;
use App\Domain\Definition\Study\ExclusionCriteriable;
use App\Domain\Definition\Study\InclusionCriteriable;
use App\Domain\Definition\Study\Participanable;
use App\Domain\Definition\Study\Populatable;
use App\Domain\Definition\Study\PowerAnalysiable;
use App\Domain\Definition\Study\SampleMethodable;
use App\Domain\Definition\Study\SampleSizeable;
use App\Domain\Model\Administration\UuidEntity;
use App\Questionnaire\Forms\SampleType;
use App\Questionnaire\Questionable;
use App\Review\Reviewable;
use App\Review\ReviewDataCollectable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class SampleMetaDataGroup extends UuidEntity implements MetaDataValuable, Questionable, Reviewable
{
    /**
     * One Sample section has One Experiment.
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="sampleMetaDataGroup")
     */
    protected $experiment;

    use ExperimentRelatable;

    use Participanable;
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

    public function getReviewCollection()
    {
        return [
            ReviewDataCollectable::createFrom('Participants', $this->getParticipants(), function () {return true;}),
            ReviewDataCollectable::createFrom('Popluation', $this->getPopulation(), function () {return true;}),
            ReviewDataCollectable::createFrom('Inclusion criteria', $this->getInclusionCriteria(), function () {return true;}),
            ReviewDataCollectable::createFrom('Exclusion criteria', $this->getExclusionCriteria(), function () {return true;}),
            ReviewDataCollectable::createFrom('Sampling Method', $this->getSamplingMethod(), function () {return true;}),
            ReviewDataCollectable::createFrom('Sample Size', $this->getSampleSize(), function () {return true;}),
            ReviewDataCollectable::createFrom('Power analysis', $this->getPowerAnalysis(), function () {return true;}),
        ];
    }

    public function getFormTypeForEntity(): string
    {
        return SampleType::class;
    }
}
