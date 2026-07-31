<?php

declare(strict_types=1);

namespace App\Entity\Project;

use App\Entity\Administration\UuidEntity;
use App\Repository\Project\ProjectAdministrativeDataRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Table(name: 'project_administrative_data')]
#[ORM\Entity(repositoryClass: ProjectAdministrativeDataRepository::class)]
class ProjectAdministrativeData extends UuidEntity
{
    #[ORM\JoinColumn(name: 'project_entity_id', referencedColumnName: 'id')]
    #[ORM\OneToOne(inversedBy: 'administrativeData')]
    protected ?Project $project = null;

    #[Groups(['project'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $projectTitle = null;

    #[Groups(['project'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $projectId = null;

    #[Groups(['project'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $projectObjectives = null;

    #[Groups(['project'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $funding = null;

    #[Groups(['project'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $grantNumber = null;

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function getProjectTitle(): ?string
    {
        return $this->projectTitle;
    }

    public function setProjectTitle(?string $projectTitle): static
    {
        $this->projectTitle = $projectTitle;

        return $this;
    }

    public function getProjectId(): ?string
    {
        return $this->projectId;
    }

    public function setProjectId(?string $projectId): static
    {
        $this->projectId = $projectId;

        return $this;
    }

    public function getProjectObjectives(): ?string
    {
        return $this->projectObjectives;
    }

    public function setProjectObjectives(?string $projectObjectives): static
    {
        $this->projectObjectives = $projectObjectives;

        return $this;
    }

    public function getFunding(): ?string
    {
        return $this->funding;
    }

    public function setFunding(?string $funding): static
    {
        $this->funding = $funding;

        return $this;
    }

    public function getGrantNumber(): ?string
    {
        return $this->grantNumber;
    }

    public function setGrantNumber(?string $grantNumber): static
    {
        $this->grantNumber = $grantNumber;

        return $this;
    }
}
