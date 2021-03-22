<?php

namespace App\Domain\Model\Study;

use App\Domain\Definition\MetaDataValuable;
use App\Domain\Definition\Study\Contactable;
use App\Domain\Definition\Study\Creatorable;
use App\Domain\Definition\Study\Descriptable;
use App\Domain\Definition\Study\RelatedPublicationable;
use App\Domain\Definition\Study\Titleable;
use App\Domain\Model\Administration\UuidEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class BasicInformationMetaDataGroup extends UuidEntity implements MetaDataValuable
{
    /**
     * One basic Information section has One Experiment.
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="basicInformationMetaDataGroup")
     */
    protected $experiment;
    use ExperimentRelatable;

    use Creatorable;
    use Contactable;
    use Titleable;
    use Descriptable;
    use RelatedPublicationable;

    public function getMetaData(): array
    {
       return [
           BasicInformationMetaDataGroup::getCreatorLabel() => $this->getCreator(),
           BasicInformationMetaDataGroup::getContactLabel() => $this->getContact(),
           BasicInformationMetaDataGroup::getTitleLabel() => $this->getTitle(),
           BasicInformationMetaDataGroup::getDescriptionLabel() => $this->getDescription(),
           BasicInformationMetaDataGroup::getRelatedPublicationsLabel() => $this->getRelatedPublications()
       ];
    }
}
