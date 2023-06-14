<?php

namespace App\Domain\Definition;

class ErrorType
{
    final public const MANDATORY = 'mandatory';
    final public const RECOMMENDED = 'recommended';
    final public const OPTIONAL = 'optional';
    final public const NONE = null;
}
