<?php


namespace App\Domain\Model\Filemanagement;


use App\Domain\Definition\Filemanagement\AtUploadNameable;
use App\Domain\Definition\Filemanagement\StorageNameable;
use App\Domain\Model\Administration\UuidEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class OriginalDataset extends UuidEntity
{
    private function __construct(){ }

    use AtUploadNameable;
    use StorageNameable;

    static public function createDataset(string $atUploadName, string $renamedFilename) {
        $file = new OriginalDataset();
        $file->setAtUploadNameable($atUploadName);
        $file->setStorageName($renamedFilename);
        return $file;
    }
}