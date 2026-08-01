<?php

declare(strict_types=1);

namespace App\Entity\Project;

use App\Entity\Administration\DataWizUser;
use App\Entity\Administration\UuidEntity;
use App\Repository\Project\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ORM\Table(name: 'project')]
#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project extends UuidEntity
{
    #[SerializedName('administrative_data')]
    #[Groups(['project'])]
    #[ORM\OneToOne(mappedBy: 'project', cascade: ['persist', 'remove'])]
    private ?ProjectAdministrativeData $administrativeData = null;

    #[SerializedName('settings')]
    #[Groups(['settings'])]
    #[ORM\OneToOne(mappedBy: 'project', cascade: ['persist', 'remove'])]
    private ?ProjectSettings $settings = null;

    #[ORM\OneToMany(targetEntity: ProjectMaterial::class, mappedBy: 'project', cascade: ['persist'])]
    #[SerializedName('material')]
    #[Groups(['project_material'])]
    private Collection $materials;

    #[ORM\ManyToOne]
    private ?DataWizUser $owner = null;

    #[ORM\Column]
    #[Timestampable(on: 'create')]
    private ?\DateTime $dateCreated = null;

    public function __construct()
    {
        $this->materials = new ArrayCollection();
    }

    public function getAdministrativeData(): ?ProjectAdministrativeData
    {
        return $this->administrativeData;
    }

    public function setAdministrativeData(?ProjectAdministrativeData $administrativeData): static
    {
        $this->administrativeData = $administrativeData;
        $administrativeData?->setProject($this);

        return $this;
    }

    public function getSettings(): ?ProjectSettings
    {
        return $this->settings;
    }

    public function setSettings(?ProjectSettings $settings): static
    {
        $this->settings = $settings;
        $settings?->setProject($this);

        return $this;
    }

    /**
     * @return Collection<int, ProjectMaterial>
     */
    public function getMaterials(): Collection
    {
        return $this->materials;
    }

    public function addMaterial(?ProjectMaterial $material): static
    {
        if (!$this->materials->contains($material)) {
            $this->materials->add($material);
        }

        return $this;
    }

    public function removeMaterial(ProjectMaterial $material): static
    {
        if ($this->materials->removeElement($material)) {
            $material->setProject($this);
        }

        return $this;
    }

    public function getOwner(): ?DataWizUser
    {
        return $this->owner;
    }

    public function setOwner(?DataWizUser $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getDateCreated(): \DateTime
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTime $dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }
}
