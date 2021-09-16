<?php
/**
 * This class provides the short name metadata.
 */

namespace App\Domain\Model\Study;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Definition\MetaDataValuable;
use App\Domain\Definition\Study\ShortNameable;
use App\Domain\Model\Administration\UuidEntity;
use App\Questionnaire\Forms\SettingsType;
use App\Questionnaire\Questionable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="experiment_settings")
 */
class SettingsMetaDataGroup extends UuidEntity implements MetaDataValuable, Questionable
{
    /**
     * One Settings section has One Experiment.
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="settingsMetaDataGroup")
     */
    protected $experiment;
    use ExperimentRelatable;

    use ShortNameable;

    public static function getImplementedMetaData(): array
    {
        return [
            MetaDataDictionary::SHORTNAME,
        ];
    }

    public function getFormTypeForEntity(): string
    {
        return SettingsType::class;
    }
}
