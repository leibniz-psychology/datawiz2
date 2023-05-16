<?php

namespace App\Domain\Model\Filemanagement;

use App\Domain\Model\Administration\UuidEntity;
use App\Domain\Model\Study\Experiment;
use App\Questionnaire\Forms\FileDescriptionType;
use App\Questionnaire\Questionable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Table(name: 'material')]
#[ORM\Entity]
class AdditionalMaterial extends UuidEntity implements Questionable
{
    #[ORM\Column(length: 256)]
    #[SerializedName('original_name')]
    #[Groups(['material'])]
    private ?string $originalName = null;

    #[ORM\Column(length: 256)]
    #[SerializedName('original_mimetype')]
    #[Groups(['material'])]
    private ?string $originalMimetype = null;

    #[ORM\Column()]
    #[SerializedName('uploaded')]
    #[Groups(['material'])]
    private ?\DateTime $dateUploaded = null;

    #[ORM\Column()]
    #[SerializedName('original_size')]
    #[Groups(['material'])]
    private ?int $originalSize = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[SerializedName('description')]
    #[Groups(['material'])]
    private ?string $description = null;

    #[ORM\Column(length: 256)]
    private ?string $storageName = null;

    #[ORM\ManyToOne(inversedBy: 'additionalMaterials')]
    private ?Experiment $experiment = null;

    public static function createMaterial(
        string $atUploadName,
        string $renamedFilename,
        int $fileSize,
        string $mimetype,
        Experiment $experiment
    ): AdditionalMaterial {
        $file = new AdditionalMaterial();
        $file->setOriginalName($atUploadName);
        $file->setStorageName($renamedFilename);
        $file->setOriginalSize($fileSize);
        $file->setExperiment($experiment);
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

    public function getExperiment(): Experiment
    {
        return $this->experiment;
    }

    public function setExperiment(Experiment $experiment): void
    {
        $this->experiment = $experiment;
        $experiment->addAdditionalMaterials($this);
    }

    public function getFormTypeForEntity(): string
    {
        return FileDescriptionType::class;
    }
}
