<?php


namespace App\Codebook;


class ValuePairModell extends AbstractJsonSerializeModell
{
    private $name;
    private $label;

    private function __construct()
    {
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

    public static function createFrom(string $name, string $value): ValuePairModell
    {
        $valuePair = new ValuePairModell();
        $valuePair->setName($name);
        $valuePair->setLabel($value);
        return $valuePair;
    }

    public static function createEmpty(): ValuePairModell
    {
        $result = new ValuePairModell();
        $result->setLabel(" ");
        $result->setName(" ");
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