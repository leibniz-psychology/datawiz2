<?php


namespace App\Domain\Model\Filemanagement;


use App\Domain\Definition\Filemanagement\AtUploadNameable;
use App\Domain\Definition\Filemanagement\StorageNameable;
use App\Domain\Model\Administration\UuidEntity;
use App\Domain\Model\Codebook\DatasetMetaData;
use App\Domain\Model\Study\Experiment;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class OriginalDataset extends UuidEntity
{
    private function __construct(){ }

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="originalDatasets")
     */
    private $experiment;

    /**
     * One Dataset has one Codebook (Owning side)
     * @var $codebook DatasetMetaData
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Codebook\DatasetMetaData", mappedBy="originalDataset", cascade={"persist"})
     */
    private $codebook;

    use AtUploadNameable;
    use StorageNameable;

    static public function createDataset(string $atUploadName, string $renamedFilename,
                                         DatasetMetaData $codebook, Experiment $experiment) {
        $file = new OriginalDataset();
        $file->setAtUploadNameable($atUploadName);
        $file->setStorageName($renamedFilename);
        $file->setExperiment($experiment);
        $file->setCodebook($codebook);
        return $file;
    }

    public function getExperiment()
    {
        return $this->experiment;
    }

    public function setExperiment(Experiment $experiment): void
    {
        $this->experiment = $experiment;
        $experiment->addOriginalDatasets($this);
    }

    public function getCodebook()
    {
        return $this->codebook;
    }

    public function setCodebook($codebook): void
    {
        $this->codebook = $codebook;
        $this->codebook->setOriginalDataset($this);
    }

}