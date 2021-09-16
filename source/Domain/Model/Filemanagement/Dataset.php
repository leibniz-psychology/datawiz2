<?php


namespace App\Domain\Model\Filemanagement;


use App\Domain\Model\Administration\UuidEntity;
use App\Domain\Model\Study\Experiment;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Dataset extends UuidEntity
{

    public function __construct()
    {
        $this->codebook = new ArrayCollection();
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="originalDatasets")
     */
    private Experiment $experiment;

    /**
     * @ORM\Column(type="string", length=256)
     */
    private string $originalName;

    /**
     * @ORM\Column(type="string", length=256)
     */
    private string $originalMimetype;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTime $dateUploaded = null;

    /**
     * @ORM\Column(type="integer")
     */
    private int $originalSize = 0;

    /**
     * @ORM\Column(type="string", length=256)
     */
    private string $storageName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Domain\Model\Codebook\DatasetVariables", mappedBy="dataset")
     */
    private Collection $codebook;


    static public function createDataset(string $atUploadName, string $renamedFilename, int $fileSize, string $mimetype, Experiment $experiment): Dataset
    {
        $file = new Dataset();
        $file->setOriginalName($atUploadName);
        $file->setStorageName($renamedFilename);
        $file->setOriginalSize($fileSize);
        $file->setExperiment($experiment);
        $file->setDateUploaded(new DateTime());
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

    /**
     * @return mixed
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * @param mixed $originalName
     */
    public function setOriginalName($originalName): void
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
     * @return mixed
     */
    public function getStorageName()
    {
        return $this->storageName;
    }

    /**
     * @param mixed $storageName
     */
    public function setStorageName($storageName): void
    {
        $this->storageName = $storageName;
    }

    /**
     * @return string
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


    /**
     * @return Collection
     */
    public function getCodebook(): Collection
    {
        return $this->codebook;
    }

    /**
     * @param Collection $codebook
     */
    public function setCodebook(Collection $codebook): void
    {
        $this->codebook = $codebook;
    }


}