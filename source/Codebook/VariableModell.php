<?php


namespace App\Codebook;


class VariableModell extends AbstractJsonSerializeModell
{
    private $id;
    private $name;
    private $label;
    private $itemText;
    private $values;
    private $missings;
    private $measure;

    private function __construct()
    {
        $this->values = [];
        $this->missings = [];
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label): void
    {
        $this->label = $label;
    }

    public function getItemText()
    {
        return $this->itemText;
    }

    public function setItemText($itemText): void
    {
        $this->itemText = $itemText;
    }

    public function getMeasure()
    {
        return $this->measure;
    }

    public function setMeasure($measure): void
    {
        $this->measure = $measure;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function addValue($addedValue)
    {
        $this->values[] = $addedValue;
    }

    public function setValues(array $values): void
    {
        $this->values = $values;
    }

    public function removeValue($removedValue)
    {
        return array_diff($this->values, [$removedValue]);
    }

    public function getMissings(): array
    {
        return $this->missings;
    }

    public function setMissings(array $missings): void
    {
        $this->missings = $missings;
    }

    public function addMissing($addedMissing)
    {
        $this->missings[] = $addedMissing;
    }

    public function removeMissing($removedMissing)
    {
        return array_diff($this->missings, [$removedMissing]);
    }

    public static function createFrom(
        string $id,
        string $name,
        string $label,
        string $itemText,
        array  $values,
        array  $missings,
        string $measure
    ): VariableModell
    {
        $variableModell = new VariableModell();

        $variableModell->setId($id);
        $variableModell->setName($name);
        $variableModell->setLabel($label);
        $variableModell->setItemText($itemText);

        foreach ($values as $value) {
            $variableModell->addValue($value);
        }

        foreach ($missings as $missing) {
            $variableModell->addMissing($missing);
        }

        $variableModell->setMeasure($measure);

        return $variableModell;
    }

    public static function createEmpty(string $id): VariableModell
    {
        $result = new VariableModell();
        $result->setId($id);
        $result->setName("");
        $result->setItemText("");
        $result->setLabel("");
        $result->addMissing(ValuePairModell::createEmpty());
        $result->addValue(ValuePairModell::createEmpty());
        $result->setMeasure("");
        return $result;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }


    public function getJsonString(): string
    {
        // TODO: Implement getJsonString() method.
        return 'unimplemented';
    }

    public static function createFromJson(string $jsonString)
    {
        // TODO: Implement createFromJson() method.
    }
}
