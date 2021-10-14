<?php

namespace App\Review;

class ReviewValidator
{
    public static function validateSingleValue(?string $value, string $errorMessage): ?string
    {
        return (null != $value && !empty($value)) ? null : $errorMessage;
    }
}