<?php


namespace App\Domain\Model\Filemanagement;


use App\Domain\Model\Administration\UuidEntity;
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
        $this->codebook = new ArrayCollection();
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
     * @ORM\OneToMany(targetEntity="App\Domain\Model\Codebook\DatasetVariables", mappedBy="dataset")
     */
    private Collection $codebook;


    static public function createDataset(string $atUploadName, string $renamedFilename, Collection $codebook, Experiment $experiment): Dataset
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