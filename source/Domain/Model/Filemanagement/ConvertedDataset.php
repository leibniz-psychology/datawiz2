<?php


namespace App\Domain\Model\Filemanagement;


use App\Domain\Model\Administration\UuidEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class ConvertedDataset extends UuidEntity
{
    // We convert from .sav to .csv
    // these files are not the same as the original
}