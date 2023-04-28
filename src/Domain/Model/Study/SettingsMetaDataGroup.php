<?php
/**
 * This class provides the short name metadata.
 */

namespace App\Domain\Model\Study;

use App\Domain\Model\Administration\UuidEntity;
use App\Questionnaire\Forms\SettingsType;
use App\Questionnaire\Questionable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="experiment_settings")
 */
class SettingsMetaDataGroup extends UuidEntity implements Questionable
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $shortName = null;

    /**
     * One Settings section has One Experiment.
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="settingsMetaDataGroup")
     */
    protected Experiment $experiment;

    public function getFormTypeForEntity(): string
    {
        return SettingsType::class;
    }

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function setShortName(?string $shortName): void
    {
        $this->shortName = $shortName;
    }

    public function getExperiment(): Experiment
    {
        return $this->experiment;
    }

    public function setExperiment(Experiment $experiment): void
    {
        $this->experiment = $experiment;
    }


}
