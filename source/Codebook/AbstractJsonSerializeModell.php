<?php


namespace App\Codebook;


use App\Io\Formats\Json\JsonExportable;
use App\Io\Formats\Json\JsonImportable;

abstract class AbstractJsonSerializeModell implements JsonImportable, JsonExportable
{
    public abstract function jsonSerialize();
    public abstract function getJsonString(): string;
    public abstract static function createFromJson(string $jsonString);
}