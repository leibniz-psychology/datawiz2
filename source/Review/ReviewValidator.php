<?php

namespace App\Review;


class ReviewValidator
{
    public static function validateSingleValue(?string $value): bool
    {
        return null != $value && !empty($value);
    }

    public static function validateArrayValues(?array $value): bool
    {
        return null != $value && null != array_values(array_filter($value));
    }
}