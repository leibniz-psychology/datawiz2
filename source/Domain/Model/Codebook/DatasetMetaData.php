<?php


namespace App\Domain\Model\Codebook;


use App\Codebook\MetaDataExchangeModell;
use App\Domain\Definition\Codebook\MetaDatable;
use App\Domain\Model\Administration\UuidEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class DatasetMetaData extends UuidEntity
{
    /**
     * One Codebook has One OriginalDataset
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Filemanagement\OriginalDataset", inversedBy="codebook", cascade={"persist"})
     */
    private $originalDataset;

    use MetaDatable;

    private function __construct()
    {
    }

    public function getOriginalDataset()
    {
        return $this->originalDataset;
    }

    public function setOriginalDataset($originalDataset): void
    {
        $this->originalDataset = $originalDataset;
    }

    public static function createEmptyCode(): DatasetMetaData
    {
        $codebook = new DatasetMetaData();
        $codebook->setMetadata(MetaDataExchangeModell::createEmpty());
        return $codebook;
    }
}