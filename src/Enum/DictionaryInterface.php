<?php

namespace App\Enum;

interface DictionaryInterface extends ExtendedEnumInterface
{
    public function legend(): ?string;

    public function help(): ?string;

    public function descriptionHelp(): ?string;
}
