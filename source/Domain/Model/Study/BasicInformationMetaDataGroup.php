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
use App\Questionnaire\FormInstructionValue;
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

    public static function getImplementedMetaData(): array
    {
       return array(
           MetaDataDictionary::CREATOR,
           MetaDataDictionary::CONTACT,
           MetaDataDictionary::TITLE,
           MetaDataDictionary::DESCRIPTION,
           MetaDataDictionary::RELATED_PUBS
       );
    }

    public static function lookUpFormInstructions(string $metadatadictionaryEntry): ?FormInstructionValue
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

    public static function getDictionaryKeys(): array
    {
        return self::getImplementedMetaData();
    }
}
