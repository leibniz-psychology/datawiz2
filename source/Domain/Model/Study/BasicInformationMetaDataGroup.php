<?php

namespace App\Domain\Model\Study;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Definition\MetaDataValuable;
use App\Domain\Definition\Study\Contactable;
use App\Domain\Definition\Study\Descriptable;
use App\Domain\Definition\Study\RelatedPublicationable;
use App\Domain\Definition\Study\Titleable;
use App\Domain\Model\Administration\UuidEntity;
use App\Questionnaire\Forms\BasicInformationType;
use App\Questionnaire\Questionable;
use App\Review\Reviewable;
use App\Review\ReviewDataCollectable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    use Contactable;
    use Titleable;
    use Descriptable;
    use RelatedPublicationable;

    /**
     * @ORM\OneToMany(targetEntity="App\Domain\Model\Study\CreatorMetaDataGroup", mappedBy="basicInformation")
     */
    private Collection $creators;

    public function __construct()
    {
        $this->creators = new ArrayCollection();
    }

    public static function getImplementedMetaData(): array
    {
        return [
            MetaDataDictionary::TITLE,
            MetaDataDictionary::DESCRIPTION,
            MetaDataDictionary::RELATED_PUBS,
            MetaDataDictionary::CREATORS,
            MetaDataDictionary::CONTACT,
        ];
    }

    public function getReviewCollection(): array
    {
        return [
            ReviewDataCollectable::createFrom('input.title.legend', $this->getTitle(), function () {
                return true;
            }),
            ReviewDataCollectable::createFrom('input.description.legend', $this->getDescription(), function () {
                return true;
            }),
            ReviewDataCollectable::createFrom('input.relatedPubs.legend', $this->getRelatedPublications(), function () {
                return true;
            }),
        ];
    }

    public function getFormTypeForEntity(): string
    {
        return BasicInformationType::class;
    }

    /**
     * @return Collection
     */
    public function getCreators(): Collection
    {
        return $this->creators;
    }

    /**
     * @param Collection $creators
     */
    public function setCreators(Collection $creators): void
    {
        $this->creators = $creators;
    }


}
