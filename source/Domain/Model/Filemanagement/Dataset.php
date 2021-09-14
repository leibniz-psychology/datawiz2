<?php


namespace App\Domain\Model\Filemanagement;


use App\Domain\Model\Administration\UuidEntity;
use App\Domain\Model\Codebook\DatasetMetaData;
use App\Domain\Model\Study\Experiment;
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
        $this->codebook2 = new ArrayCollection();
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="originalDatasets")
     */
    private Experiment $experiment;

    /**
     * @ORM\Column() (type="string", length=256)
     */
    private string $atUploadNameable;

    /**
     * @ORM\Column(type="string", length=256)
     */
    private string $storageName;

    /**
     * One Dataset has one Codebook (Owning side)
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Codebook\DatasetMetaData", mappedBy="dataset", cascade={"persist"})
     */
    private DatasetMetaData $codebook;

    /**
     * @ORM\OneToMany(targetEntity="App\Domain\Model\Codebook\DatasetVariables", mappedBy="dataset")
     */
    private Collection $codebook2;


    static public function createDataset(string $atUploadName, string $renamedFilename, DatasetMetaData $codebook, Experiment $experiment): Dataset
    {
        $file = new Dataset();
        $file->setAtUploadNameable($atUploadName);
        $file->setStorageName($renamedFilename);
        $file->setExperiment($experiment);
        $file->setCodebook($codebook);

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
    public function getAtUploadNameable()
    {
        return $this->atUploadNameable;
    }

    /**
     * @param mixed $atUploadNameable
     */
    public function setAtUploadNameable($atUploadNameable): void
    {
        $this->atUploadNameable = $atUploadNameable;
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
     * @return DatasetMetaData
     */
    public function getCodebook(): DatasetMetaData
    {
        return $this->codebook;
    }

    /**
     * @param $codebook
     */
    public function setCodebook($codebook): void
    {
        $this->codebook = $codebook;
        $this->codebook->setDataset($this);
    }

    /**
     * @return Collection
     */
    public function getCodebook2(): Collection
    {
        return $this->codebook2;
    }

    /**
     * @param Collection $codebook2
     */
    public function setCodebook2(Collection $codebook2): void
    {
        $this->codebook2 = $codebook2;
    }


}