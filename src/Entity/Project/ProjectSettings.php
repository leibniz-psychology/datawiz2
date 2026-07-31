<?php

declare(strict_types=1);

namespace App\Entity\Project;

use App\Entity\Administration\UuidEntity;
use App\Repository\Project\ProjectSettingsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Table(name: 'project_settings')]
#[ORM\Entity(repositoryClass: ProjectSettingsRepository::class)]
class ProjectSettings extends UuidEntity
{
    #[ORM\OneToOne(inversedBy: 'settings')]
    protected ?Project $project = null;

    #[Groups(['project'])]
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

    public function getProject(): Project
    {
        return $this->project;
    }

    public function setProject(Project $project): void
    {
        $this->project = $project;
    }
}
