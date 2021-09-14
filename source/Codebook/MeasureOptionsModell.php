<?php

namespace App\Codebook;

class MeasureOptionsModell extends AbstractJsonSerializeModell
{
    private function __construct()
    {
    }

    private array $measures;

    public function getMeasures(): array
    {
        return $this->measures;
    }

    public function setMeasures(array $measures): void
    {
        $this->measures = $measures;
    }

    public function addMeasure(string $addedMeasure)
    {
        $this->measures[] = $addedMeasure;
    }

    public function removeMeasure(string $removedMeasure)
    {
        $this->measures = array_diff($this->measures, [$removedMeasure]);
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public static function createFromJson(string $jsonString)
    {
    }

    public function getJsonString(): string
    {
        return json_encode($this);
    }

    public static function createFrom(array $measures): MeasureOptionsModell
    {
        $result = new MeasureOptionsModell();
        foreach ($measures as $entry) {
            if ($entry && "" != $entry) {
                $result->addMeasure($entry);
            }
        }

        return $result;
    }

    public static function createEmpty(): MeasureOptionsModell
    {
        return new MeasureOptionsModell();
    }


}