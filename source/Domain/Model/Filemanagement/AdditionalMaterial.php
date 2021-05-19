<?php


namespace App\Domain\Model\Filemanagement;


use App\Domain\Definition\Filemanagement\AtUploadNameable;
use App\Domain\Model\Administration\UuidEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class AdditionalMaterial extends UuidEntity
{
    private function __construct(){ }

    use AtUploadNameable;

    static public function createMaterial(string $atUploadName) {
        $file = new AdditionalMaterial();
        $file->setAtUploadNameable($atUploadName);
        return $file;
    }

}