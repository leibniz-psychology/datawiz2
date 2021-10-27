<?php


namespace App\Domain\Model\Filemanagement;


use App\Domain\Model\Administration\UuidEntity;
use App\Domain\Model\Study\Experiment;
use App\Questionnaire\Forms\FileDescriptionType;
use App\Questionnaire\Questionable;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity()
 * @ORM\Table(name="material")
 */
class AdditionalMaterial extends UuidEntity implements Questionable
{

    static public function createMaterial(
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
        $file->setDateUploaded(new DateTime());
        $file->setOriginalMimetype($mimetype);

        return $file;
    }

    /**
     * @ORM\Column(type="string", length=256)
     * @SerializedName("original_name")
     * @Groups({"material"})
     */
    private string $originalName;

    /**
     * @ORM\Column(type="string", length=256)
     * @SerializedName("original_mimetype")
     * @Groups({"material"})
     */
    private string $originalMimetype;

    /**
     * @ORM\Column(type="datetime")
     * @SerializedName("uploaded")
     * @Groups({"material"})
     */
    private ?DateTime $dateUploaded = null;

    /**
     * @ORM\Column(type="integer")
     * @SerializedName("original_size")
     * @Groups({"material"})
     */
    private int $originalSize = 0;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @SerializedName("description")
     * @Groups({"material"})
     */
    private ?string $description = null;

    /**
     * @ORM\Column(type="string", length=256)
     */
    private string $storageName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="additionalMaterials")
     */
    private Experiment $experiment;

    /**
     * @return string
     */
    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    /**
     * @param string $originalName
     */
    public function setOriginalName(string $originalName): void
    {
        $this->originalName = $originalName;
    }

    /**
     * @return string
     */
    public function getOriginalMimetype(): string
    {
        return $this->originalMimetype;
    }

    /**
     * @param string $originalMimetype
     */
    public function setOriginalMimetype(string $originalMimetype): void
    {
        $this->originalMimetype = $originalMimetype;
    }

    /**
     * @return DateTime|null
     */
    public function getDateUploaded(): ?DateTime
    {
        return $this->dateUploaded;
    }

    /**
     * @param DateTime|null $dateUploaded
     */
    public function setDateUploaded(?DateTime $dateUploaded): void
    {
        $this->dateUploaded = $dateUploaded;
    }

    /**
     * @return int
     */
    public function getOriginalSize(): int
    {
        return $this->originalSize;
    }

    /**
     * @param int $originalSize
     */
    public function setOriginalSize(int $originalSize): void
    {
        $this->originalSize = $originalSize;
    }

    /**
     * @return string
     */
    public function getStorageName(): string
    {
        return $this->storageName;
    }

    /**
     * @param string $storageName
     */
    public function setStorageName(string $storageName): void
    {
        $this->storageName = $storageName;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
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