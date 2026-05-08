<?php

namespace App\Enum;

use App\Entity\Dto\ReviewDataDto;

interface DictionaryInterface extends ExtendedEnumInterface
{
    public function legend(): ?string;

    public function help(): ?string;

    public function descriptionHelp(): ?string;

    public function reviewData(): ?ReviewDataDto;
}
