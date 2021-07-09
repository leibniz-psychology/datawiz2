<?php


namespace App\Domain\Model\Codebook;


class ValuePairModell implements \JsonSerializable
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

    // public static function createFromJson(string $json) ?

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }


}