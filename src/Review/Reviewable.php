<?php


namespace App\Review;


interface Reviewable
{
    /**
     * @return ReviewDataCollectable[]
     */
    public function getReviewCollection();
}