<?php


namespace App\Review;


trait Displayable
{
    public static function alwaysDisplayValue()
    {
        return true;
    }

    public static function neverDisplayValue()
    {
        return false;
    }
}