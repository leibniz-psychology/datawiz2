<?php

namespace App\Domain\Definition\Datatypes;

use App\Domain\Definition\MetaDataValuable;

/**
 * Defines the basic feature of text metdata within DataWiz.
 */
interface DataWizTextable extends MetaDataValuable
{
    const TextEncoding = 'UTF8';
}
