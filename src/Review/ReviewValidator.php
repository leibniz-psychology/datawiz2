<?php

namespace App\Review;

class ReviewValidator
{
    public static function validateSingleValue(?string $value): bool
    {
        return $value != null && !empty($value);
    }

    public static function validateArrayValues(?array $value): bool
    {
        return $value != null && array_values(array_filter($value)) != null;
    }
}
