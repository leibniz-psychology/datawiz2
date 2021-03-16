<?php
/**
 * This class provides the short name metadata.
 */

namespace App\Domain\Model\Study;

use App\Domain\Access\Study\ExperiementRepository;
use App\Domain\Definition\Study\ShortNameable;
use App\Domain\Model\Administration\UuidEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class SettingsMetaDataGroup extends UuidEntity implements ShortNameable
{
    /**
     * One Settings section has One Experiment.
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="settingsMetaDataGroup")
     */
    protected $experiment;

    use ExperimentRelatable;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $shortName;

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function setShortName(string $newShortName): void
    {
        $this->shortName = $newShortName;
    }
}
