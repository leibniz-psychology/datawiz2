<?php


namespace App\Io\Formats\Json;


interface JsonImportable
{
    public static function createFromJson(string $jsonString);
}