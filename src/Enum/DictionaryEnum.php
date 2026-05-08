<?php

namespace App\Enum;

use App\Entity\Dto\ReviewDataDto;

trait DictionaryEnum
{
    public function legend(): ?string
    {
        return null;
    }

    public function placeholder(): ?string
    {
        return null;
    }

    public function help(): ?string
    {
        return null;
    }

    public function descriptionHelp(): ?string
    {
        return null;
    }

    public function reviewData(): ?ReviewDataDto
    {
        return null;
    }
}
