<?php


namespace App\Domain\Model\Codebook;


use App\Codebook\MetaDataExchangeModell;
use App\Domain\Model\Administration\UuidEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class DatasetMetaData extends UuidEntity
{
    /**
     * One Codebook has One Dataset
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Filemanagement\Dataset", inversedBy="codebook")
     */
    private $dataset;

    /**
     * @var array
     * @ORM\Column(type="json", nullable=true)
     */
    private $metadata;

    private function __construct()
    {
    }

    public function getMetadata()
    {
        return $this->metadata;
    }

    public function setMetadata($metadata): void
    {
        $this->metadata = $metadata;
    }

    /**
     * @return mixed
     */
    public function getDataset()
    {
        return $this->dataset;
    }

    /**
     * @param mixed $dataset
     */
    public function setDataset($dataset): void
    {
        $this->dataset = $dataset;
    }


    public static function createEmptyCode(): DatasetMetaData
    {
        $codebook = new DatasetMetaData();
        $codebook->setMetadata(MetaDataExchangeModell::createEmpty());

        return $codebook;
    }
}