<?php

namespace App\Entity\FileManagement;

use App\Entity\Administration\UuidEntity;
use App\Entity\Study\Experiment;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity]
class Dataset extends UuidEntity
{
    #[ORM\ManyToOne(inversedBy: 'originalDatasets')]
    private ?Experiment $experiment = null;

    #[ORM\Column(length: 256)]
    #[SerializedName('original_name')]
    #[Groups(['dataset'])]
    private ?string $originalName = null;

    #[ORM\Column(length: 256)]
    #[SerializedName('original_mimetype')]
    #[Groups(['dataset'])]
    private ?string $originalMimetype = null;

    #[ORM\Column]
    #[SerializedName('uploaded')]
    #[Groups(['dataset'])]
    private ?\DateTime $dateUploaded = null;

    #[ORM\Column]
    #[SerializedName('original_size')]
    #[Groups(['dataset'])]
    private ?int $originalSize = null;

    #[ORM\Column(length: 256)]
    private ?string $storageName = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[SerializedName('description')]
    #[Groups(['dataset'])]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'dataset', targetEntity: 'App\Entity\Codebook\DatasetVariables')]
    #[SerializedName('codebook')]
    #[Groups(['codebook'])]
    private Collection $codebook;

    public function __construct()
    {
        $this->codebook = new ArrayCollection();
    }

    public static function createDataset(string $atUploadName, string $renamedFilename, int $fileSize, string $mimetype, Experiment $experiment): Dataset
    {
        $file = new Dataset();
        $file->setOriginalName($atUploadName);
        $file->setStorageName($renamedFilename);
        $file->setOriginalSize($fileSize);
        $file->setExperiment($experiment);
        $file->setDateUploaded(new \DateTime());
        $file->setOriginalMimetype($mimetype);

        return $file;
    }

    public function getExperiment(): Experiment
    {
        return $this->experiment;
    }

    public function setExperiment(Experiment $experiment): void
    {
        $this->experiment = $experiment;
        $experiment->addOriginalDatasets($this);
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

    public function setStorageName(mixed $storageName): void
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

    public function getCodebook(): Collection
    {
        return $this->codebook;
    }

    public function setCodebook(Collection $codebook): void
    {
        $this->codebook = $codebook;
    }
}
