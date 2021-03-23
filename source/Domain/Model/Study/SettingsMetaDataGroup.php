<?php
/**
 * This class provides the short name metadata.
 */

namespace App\Domain\Model\Study;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Definition\MetaDataValuable;
use App\Domain\Definition\Study\ShortNameable;
use App\Domain\Model\Administration\UuidEntity;
use App\Questionnaire\FormInstructionValue;
use App\Questionnaire\Questionable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class SettingsMetaDataGroup extends UuidEntity implements MetaDataValuable, Questionable
{
    /**
     * One Settings section has One Experiment.
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="settingsMetaDataGroup")
     */
    protected $experiment;
    use ExperimentRelatable;

    use ShortNameable;

    public static function getImplementedMetaData(): array
    {
        return array(
            MetaDataDictionary::SHORTNAME
        );
    }

    public static function lookUpFormInstructions(string $metadatadictionaryEntry): ?FormInstructionValue
    {
        switch ($metadatadictionaryEntry) {
            case MetaDataDictionary::SHORTNAME:
                return self::getShortNameOptions();
            default:
                return null;

        }
    }

    public static function getDictionaryKeys(): array
    {
        return self::getImplementedMetaData();
    }
}
