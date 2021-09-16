<?php


namespace App\Domain\Model\Filemanagement;


use App\Domain\Definition\Filemanagement\AtUploadNameable;
use App\Domain\Definition\Filemanagement\FileDescribeable;
use App\Domain\Definition\Filemanagement\FileSizeable;
use App\Domain\Definition\Filemanagement\FileTypeable;
use App\Domain\Definition\Filemanagement\StorageNameable;
use App\Domain\Definition\Filemanagement\UploadDateable;
use App\Domain\Model\Administration\UuidEntity;
use App\Domain\Model\Study\Experiment;
use App\Questionnaire\Forms\FileDescriptionType;
use App\Questionnaire\Questionable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="material")
 */
class AdditionalMaterial extends UuidEntity implements Questionable
{
    private function __construct(){ }

    static public function createMaterial(string $atUploadName, string $renamedFilename,
                                          Experiment $experiment) {
        $file = new AdditionalMaterial();
        $file->setAtUploadNameable($atUploadName);
        $file->setStorageName($renamedFilename);
        $file->setExperiment($experiment);
        return $file;
    }

    use AtUploadNameable;
    use StorageNameable;
    use UploadDateable;
    use FileSizeable;
    use FileTypeable;
    use FileDescribeable;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="additionalMaterials")
     */
    private $experiment;

    public function getExperiment()
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