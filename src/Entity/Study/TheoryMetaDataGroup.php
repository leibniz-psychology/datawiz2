<?php

namespace App\Entity\Study;

use App\Entity\Administration\UuidEntity;
use App\Repository\TheoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ORM\Table(name: 'experiment_theory')]
#[ORM\Entity(repositoryClass: TheoryRepository::class)]
class TheoryMetaDataGroup extends UuidEntity
{
    /**
     * One Theory section has One Experiment.
     */
    #[ORM\OneToOne(inversedBy: 'theoryMetaDataGroup', cascade: ['persist', 'remove'])]
    protected ?Experiment $experiment = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('objectives')]
    #[Groups(['study'])]
    private ?array $objectives = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('hypotheses')]
    #[Groups(['study'])]
    private ?array $hypotheses = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('theories')]
    #[Groups(['study'])]
    private ?array $theories = null;

    public function getExperiment(): Experiment
    {
        return $this->experiment;
    }

    public function setExperiment(Experiment $experiment): void
    {
        $this->experiment = $experiment;
    }

    public function getObjectives(): ?array
    {
        return $this->objectives;
    }

    public function setObjectives(?array $objectives): void
    {
        $this->objectives = $objectives;
    }

    public function getHypotheses(): ?array
    {
        return $this->hypotheses;
    }

    public function setHypotheses(?array $hypotheses): void
    {
        $this->hypotheses = $hypotheses;
    }

    public function getTheories(): ?array
    {
        return $this->theories;
    }

    public function setTheories(?array $theories): static
    {
        $this->theories = $theories;

        return $this;
    }
}
