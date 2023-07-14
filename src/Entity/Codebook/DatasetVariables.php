<?php

namespace App\Entity\Codebook;

use App\Entity\Administration\UuidEntity;
use App\Entity\FileManagement\Dataset;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity]
class DatasetVariables extends UuidEntity
{
    #[ORM\Column]
    private int $varId;

    #[ORM\Column(length: 250)]
    #[SerializedName('name')]
    #[Groups(['codebook'])]
    private string $name;

    #[ORM\Column(length: 500, nullable: true)]
    #[SerializedName('label')]
    #[Groups(['codebook'])]
    private ?string $label = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[SerializedName('item_text')]
    #[Groups(['codebook'])]
    private ?string $itemText = null;

    #[ORM\Column(name: 'val_label', type: 'json', nullable: true)]
    #[SerializedName('value_label')]
    #[Groups(['codebook'])]
    private ?array $values = null;

    #[ORM\Column(type: 'json', nullable: true)]
    #[SerializedName('missings')]
    #[Groups(['codebook'])]
    private ?array $missings = null;

    #[ORM\Column(length: 250, nullable: true)]
    #[SerializedName('measure')]
    #[Groups(['codebook'])]
    private ?string $measure = null;

    #[ORM\ManyToOne(inversedBy: 'codebook')]
    #[ORM\JoinColumn(name: 'dataset_id', referencedColumnName: 'id')]
    private ?Dataset $dataset = null;

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

    public function getDataset(): Dataset
    {
        return $this->dataset;
    }

    public function setDataset(Dataset $dataset): void
    {
        $this->dataset = $dataset;
    }

    public function getVarId(): int
    {
        return $this->varId;
    }

    public function setVarId(int $varId): void
    {
        $this->varId = $varId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): void
    {
        $this->label = $label;
    }

    public function getItemText(): ?string
    {
        return $this->itemText;
    }

    public function setItemText(?string $itemText): void
    {
        $this->itemText = $itemText;
    }

    public function getValues(): ?array
    {
        return $this->values;
    }

    public function setValues(?array $values): void
    {
        $this->values = $values;
    }

    public function getMissings(): ?array
    {
        return $this->missings;
    }

    public function setMissings(?array $missings): void
    {
        $this->missings = $missings;
    }

    public function getMeasure(): ?string
    {
        return $this->measure;
    }

    public function setMeasure(?string $measure): void
    {
        $this->measure = $measure;
    }
}
