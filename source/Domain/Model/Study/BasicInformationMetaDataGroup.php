<?php

namespace App\Domain\Model\Study;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Definition\MetaDataValuable;
use App\Domain\Definition\Study\Contactable;
use App\Domain\Definition\Study\Creatorable;
use App\Domain\Definition\Study\Descriptable;
use App\Domain\Definition\Study\RelatedPublicationable;
use App\Domain\Definition\Study\Titleable;
use App\Domain\Model\Administration\UuidEntity;
use App\Questionnaire\Forms\BasicInformationType;
use App\Questionnaire\Questionable;
use App\Review\Reviewable;
use App\Review\ReviewDataCollectable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="experiment_basic")
 */
class BasicInformationMetaDataGroup extends UuidEntity implements MetaDataValuable, Questionable, Reviewable
{
    /**
     * One basic Information section has One Experiment.
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="basicInformationMetaDataGroup")
     */
    protected $experiment;
    use ExperimentRelatable;

    use Creatorable;
    use Contactable;
    use Titleable;
    use Descriptable;
    use RelatedPublicationable;

    public static function getImplementedMetaData(): array
    {
        return [
           MetaDataDictionary::CREATOR,
           MetaDataDictionary::CONTACT,
           MetaDataDictionary::TITLE,
           MetaDataDictionary::DESCRIPTION,
           MetaDataDictionary::RELATED_PUBS,
       ];
    }

    public function getReviewCollection()
    {
        return [
            ReviewDataCollectable::createFrom('Title', $this->getTitle(), function () {return true;}),
            ReviewDataCollectable::createFrom('Description', $this->getDescription(), function () {return true;}),
            ReviewDataCollectable::createFrom('Related Publications', $this->getRelatedPublications(), function () {return true;})
        ];
    }

    public function getFormTypeForEntity(): string
    {
        return BasicInformationType::class;
    }
}
