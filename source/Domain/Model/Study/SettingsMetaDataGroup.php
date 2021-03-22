<?php
/**
 * This class provides the short name metadata.
 */

namespace App\Domain\Model\Study;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Definition\MetaDataValuable;
use App\Domain\Definition\Study\ShortNameable;
use App\Domain\Model\Administration\UuidEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class SettingsMetaDataGroup extends UuidEntity implements MetaDataValuable
{
    /**
     * One Settings section has One Experiment.
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="settingsMetaDataGroup")
     */
    protected $experiment;
    use ExperimentRelatable;

    use ShortNameable;

    public function getMetaData(): array
    {
        return [
            MetaDataDictionary::SHORTNAME => $this->getShortName(),
        ];
    }
}
