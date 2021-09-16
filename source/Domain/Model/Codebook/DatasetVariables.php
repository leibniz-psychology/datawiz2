<?php


namespace App\Domain\Model\Codebook;


use App\Domain\Model\Administration\UuidEntity;
use App\Domain\Model\Filemanagement\Dataset;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class DatasetVariables extends UuidEntity
{

    /**
     * @param Dataset $dataset
     * @param int $varId
     * @param string $name
     * @param string|null $label
     * @param string|null $itemText
     * @param array|null $values
     * @param array|null $missings
     * @param string|null $measure
     * @return DatasetVariables
     */
    public static function createNew(
        Dataset $dataset,
        int $varId,
        string $name,
        ?string $label = null,
        ?string $itemText = null,
        ?array $values = null,
        ?array $missings = null,
        ?string $measure = null

    ): DatasetVariables {
        $dv = new DatasetVariables();
        $dv->setDataset($dataset);
        $dv->setVarId($varId);
        $dv->setName($name);
        $dv->setLabel($label);
        $dv->setItemText($itemText);
        $dv->setValues($values);
        $dv->setMissings($missings);
        $dv->setValues($values);
        $dv->setMeasure($measure);

        return $dv;
    }


    /**
     * @ORM\Column(type="integer")
     */
    private int $varId;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private ?string $label = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $itemText = null;

    /**
     * @ORM\Column(type="array", nullable=true, name="val_label")
     */
    private ?array $values = null;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private ?array $missings = null;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private ?string $measure = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Model\Filemanagement\Dataset", inversedBy="codebook")
     * @ORM\JoinColumn(name="dataset_id", referencedColumnName="id")
     */
    private Dataset $dataset;


    /**
     * @return Dataset
     */
    public function getDataset(): Dataset
    {
        return $this->dataset;
    }

    /**
     * @param Dataset $dataset
     */
    public function setDataset(Dataset $dataset): void
    {
        $this->dataset = $dataset;
    }

    /**
     * @return int
     */
    public function getVarId(): int
    {
        return $this->varId;
    }

    /**
     * @param int $varId
     */
    public function setVarId(int $varId): void
    {
        $this->varId = $varId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string|null $label
     */
    public function setLabel(?string $label): void
    {
        $this->label = $label;
    }

    /**
     * @return string|null
     */
    public function getItemText(): ?string
    {
        return $this->itemText;
    }

    /**
     * @param string|null $itemText
     */
    public function setItemText(?string $itemText): void
    {
        $this->itemText = $itemText;
    }

    /**
     * @return array|null
     */
    public function getValues(): ?array
    {
        return $this->values;
    }

    /**
     * @param array|null $values
     */
    public function setValues(?array $values): void
    {
        $this->values = $values;
    }

    /**
     * @return array|null
     */
    public function getMissings(): ?array
    {
        return $this->missings;
    }

    /**
     * @param array|null $missings
     */
    public function setMissings(?array $missings): void
    {
        $this->missings = $missings;
    }

    /**
     * @return string|null
     */
    public function getMeasure(): ?string
    {
        return $this->measure;
    }

    /**
     * @param string|null $measure
     */
    public function setMeasure(?string $measure): void
    {
        $this->measure = $measure;
    }


}