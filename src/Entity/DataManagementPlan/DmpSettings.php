<?php

/**
 * This class provides the short name metadata.
 */

namespace App\Entity\DataManagementPlan;

use App\Entity\Administration\UuidEntity;
use App\Repository\DataManagementPlan\DmpSettingsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'dmp_settings')]
#[ORM\Entity(repositoryClass: DmpSettingsRepository::class)]
class DmpSettings extends UuidEntity
{
    #[ORM\OneToOne(inversedBy: 'settings')]
    protected ?DataManagementPlan $dataManagementPlan = null;

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

    public function getDataManagementPlan(): DataManagementPlan
    {
        return $this->dataManagementPlan;
    }

    public function setDataManagementPlan(DataManagementPlan $dataManagementPlan): void
    {
        $this->dataManagementPlan = $dataManagementPlan;
    }
}
