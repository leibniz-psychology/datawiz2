<?php

namespace App\Domain\Definition\Study;

use App\Domain\Definition\Datatypes\DataWizTextable;

/**
 * A study will have a short name to become easily recognizable by the user
 * Gurantee a writable/readable property exists through the given methods.
 */
interface ShortNameable extends DataWizTextable
{
    public function getShortName(): ?string;

    public function setShortName(string $newShortName): void;
}
