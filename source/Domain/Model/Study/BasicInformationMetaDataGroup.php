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
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class BasicInformationMetaDataGroup extends UuidEntity implements MetaDataValuable, Questionable
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
           MetaDataDictionary::CREATOR => $this->getCreator(),
           MetaDataDictionary::CONTACT => $this->getContact(),
           MetaDataDictionary::TITLE => $this->getTitle(),
           MetaDataDictionary::DESCRIPTION => $this->getDescription(),
           MetaDataDictionary::RELATED_PUBS => $this->getRelatedPublications()
       ];
    }

    public static function provideFormConfigurationFor(string $metadatadictionaryEntry): ?array
    {
        switch ($metadatadictionaryEntry) {
            case MetaDataDictionary::CREATOR:
                return self::getCreatorOptions();
            case MetaDataDictionary::CONTACT:
                return self::getContactOptions();
            case MetaDataDictionary::TITLE:
                return self::getTitleOptions();
            case MetaDataDictionary::DESCRIPTION:
                return self::getDescriptionOptions();
            case MetaDataDictionary::RELATED_PUBS:
                return self::getRelatedPublicationOptions();
            default:
                return null;
        }
    }

    public static function provideAllFormConfigurations(): array
    {
        return [
            MetaDataDictionary::CREATOR => self::getCreatorOptions(),
            MetaDataDictionary::CONTACT => self::getContactOptions(),
            MetaDataDictionary::TITLE => self::getTitleOptions(),
            MetaDataDictionary::DESCRIPTION => self::getDescriptionOptions(),
            MetaDataDictionary::RELATED_PUBS => self::getRelatedPublicationOptions()
        ];
    }
}
