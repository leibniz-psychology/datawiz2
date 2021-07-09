<?php


namespace App\Io\Formats\Json;


interface JsonExportable extends \JsonSerializable
{
    public function getJsonString(): string;
}