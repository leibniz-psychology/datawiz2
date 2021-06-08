<?php


namespace App\Domain\Model\Filemanagement;


use App\Domain\Definition\Filemanagement\AtUploadNameable;
use App\Domain\Definition\Filemanagement\StorageNameable;
use App\Domain\Model\Administration\UuidEntity;
use App\Domain\Model\Study\Experiment;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class AdditionalMaterial extends UuidEntity
{
    private function __construct(){ }

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="additionalMaterials")
     */
    private $experiment;

    use AtUploadNameable;
    use StorageNameable;

    static public function createMaterial(string $atUploadName, string $renamedFilename,Experiment $experiment) {
        $file = new AdditionalMaterial();
        $file->setAtUploadNameable($atUploadName);
        $file->setStorageName($renamedFilename);
        $file->setExperiment($experiment);
        return $file;
    }

    public function getExperiment()
    {
        return $this->experiment;
    }

    public function setExperiment(Experiment $experiment): void
    {
        $this->experiment = $experiment;
        $experiment->addAdditionalMaterials($this);
    }
}