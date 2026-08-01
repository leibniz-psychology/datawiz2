<?php

declare(strict_types=1);

namespace App\Entity\Project;

use App\Entity\Administration\UuidEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ORM\Table(name: 'project_material')]
#[ORM\Entity]
class ProjectMaterial extends UuidEntity
{
    #[ORM\Column(length: 256)]
    #[SerializedName('original_name')]
    #[Groups(['project_material'])]
    private ?string $originalName = null;

    #[ORM\Column(length: 256)]
    #[SerializedName('original_mimetype')]
    #[Groups(['project_material'])]
    private ?string $originalMimetype = null;

    #[ORM\Column]
    #[SerializedName('uploaded')]
    #[Groups(['project_material'])]
    private ?\DateTime $dateUploaded = null;

    #[ORM\Column]
    #[SerializedName('original_size')]
    #[Groups(['project_material'])]
    private ?int $originalSize = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[SerializedName('description')]
    #[Groups(['project_material'])]
    private ?string $description = null;

    #[ORM\Column(length: 256)]
    private ?string $storageName = null;

    #[ORM\ManyToOne(inversedBy: 'materials')]
    private ?Project $project = null;

    public static function createMaterial(
        string $atUploadName,
        string $renamedFilename,
        int $fileSize,
        string $mimetype,
        Project $project
    ): ProjectMaterial {
        $file = new ProjectMaterial();
        $file->setOriginalName($atUploadName);
        $file->setStorageName($renamedFilename);
        $file->setOriginalSize($fileSize);
        $file->setProject($project);
        $file->setDateUploaded(new \DateTime());
        $file->setOriginalMimetype($mimetype);

        return $file;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function setOriginalName(string $originalName): void
    {
        $this->originalName = $originalName;
    }

    public function getOriginalMimetype(): string
    {
        return $this->originalMimetype;
    }

    public function setOriginalMimetype(string $originalMimetype): void
    {
        $this->originalMimetype = $originalMimetype;
    }

    public function getDateUploaded(): ?\DateTime
    {
        return $this->dateUploaded;
    }

    public function setDateUploaded(?\DateTime $dateUploaded): void
    {
        $this->dateUploaded = $dateUploaded;
    }

    public function getOriginalSize(): int
    {
        return $this->originalSize;
    }

    public function setOriginalSize(int $originalSize): void
    {
        $this->originalSize = $originalSize;
    }

    public function getStorageName(): string
    {
        return $this->storageName;
    }

    public function setStorageName(string $storageName): void
    {
        $this->storageName = $storageName;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getProject(): Project
    {
        return $this->project;
    }

    public function setProject(Project $project): void
    {
        $this->project = $project;
        $project->addMaterial($this);
    }
}
