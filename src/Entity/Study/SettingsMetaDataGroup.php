<?php
/**
 * This class provides the short name metadata.
 */

namespace App\Entity\Study;

use App\Entity\Administration\UuidEntity;
use App\Form\SettingsType;
use App\Service\Questionnaire\Questionable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'experiment_settings')]
#[ORM\Entity]
class SettingsMetaDataGroup extends UuidEntity implements Questionable
{
    /**
     * One Settings section has One Experiment.
     */
    #[ORM\OneToOne(inversedBy: 'settingsMetaDataGroup')]
    protected ?Experiment $experiment = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $shortName = null;

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
