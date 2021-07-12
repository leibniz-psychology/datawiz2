<?php


namespace App\Codebook;


class ValuePairModell extends AbstractJsonSerializeModell
{
    private $name;
    private $value;

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

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): void
    {
        $this->value = $value;
    }

    public static function createFrom(string $name, string $value): ValuePairModell
    {
        $valuePair = new ValuePairModell();
        $valuePair->setName($name);
        $valuePair->setValue($value);
        return $valuePair;
    }

    public static function createEmpty(): ValuePairModell
    {
        return new ValuePairModell();
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