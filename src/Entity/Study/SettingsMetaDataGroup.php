<?php

/**
 * This class provides the short name metadata.
 */

namespace App\Entity\Study;

use App\Entity\Administration\UuidEntity;
use App\Repository\Study\SettingsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'experiment_settings')]
#[ORM\Entity(repositoryClass: SettingsRepository::class)]
class SettingsMetaDataGroup extends UuidEntity
{
    /**
     * One Settings section has One Experiment.
     */
    #[ORM\OneToOne(inversedBy: 'settingsMetaDataGroup', cascade: ['persist', 'remove'])]
    protected ?Experiment $experiment = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $shortName = null;

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
