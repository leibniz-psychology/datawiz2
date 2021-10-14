<?php

namespace App\Review;


class ReviewValidator
{
    public static function validateSingleValue(?string $value, string $errorMessage): ?string
    {
        return (null != $value && !empty($value)) ? null : $errorMessage;
    }

    public static function validateArrayValues(?array $value, string $errorMessage): ?string
    {
        return (null != $value && null != array_values(array_filter($value))) ? null : $errorMessage;
    }
}