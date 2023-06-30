<?php

namespace App\Service\Review;

interface Reviewable
{
    /**
     * @return ReviewDataCollectable[]
     */
    public function getReviewCollection(): array;
}
