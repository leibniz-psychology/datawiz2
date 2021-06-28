<?php


namespace App\Domain\Model\Codebook;


use App\Domain\Definition\Codebook\MetaDatable;
use App\Domain\Model\Administration\UuidEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class DatasetMetaData extends UuidEntity
{
    use MetaDatable;

    private function __construct()
    {
    }

    public static function createEmptyCode(): DatasetMetaData
    {
        return new DatasetMetaData();
    }
}