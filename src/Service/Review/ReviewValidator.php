<?php

namespace App\Service\Review;

class ReviewValidator
{
    public static function validateSingleValue(?string $value): bool
    {
        return !empty($value);
    }

    public static function validateArrayValues(?array $value): bool
    {
        return $value != null && array_values(array_filter($value)) != null;
    }
}
