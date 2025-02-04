<?php

namespace App\Entity\Dto;

final readonly class CsvConfigDto
{
    public function __construct(
        public string $datasetImportDelimiter = ',',
        public string $datasetImportEscape = 'double',
        public int $datasetImportHeaderRows = 0,
        public ?bool $datasetImportRemove = null,
    ) {}
}
