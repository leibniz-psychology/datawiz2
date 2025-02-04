<?php

namespace App\Entity\Dto;

final readonly class ExportDto
{
    public function __construct(
        public string $format,

        /**
         * @var null|string[]
         */
        public ?array $datasets,

        /**
         * @var null|string[]
         */
        public ?array $materials,
    ) {}
}
