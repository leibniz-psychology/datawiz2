<?php

namespace App\Entity\Dto;

use App\Enum\ErrorType;

final readonly class ReviewDataDto
{
    public function __construct(
        public string $errorMessage,
        public ErrorType $errorType,
    ) {
    }
}
