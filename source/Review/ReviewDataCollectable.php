<?php


namespace App\Review;


final class ReviewDataCollectable
{
    private $dataName;
    private $dataValue;

    /**
     * @var $displayCondition \Closure
     */
    private $displayCondition;

    private function __construct()
    {
    }

    public function getDataName()
    {
        return $this->dataName;
    }

    public function setDataName($dataName): void
    {
        $this->dataName = $dataName;
    }

    public function getDataValue()
    {
        return $this->dataValue;
    }

    public function setDataValue($dataValue): void
    {
        $this->dataValue = $dataValue;
    }

    public function getDisplayCondition()
    {
        return $this->displayCondition->call($this);
    }

    public function setDisplayCondition($displayCondition): void
    {
        $this->displayCondition = $displayCondition;
    }

    public static function createEmpty(): ReviewDataCollectable
    {
        return new ReviewDataCollectable();
    }

    public static function createFrom(string $dataName, $dataValue, \Closure $displayCondition): ReviewDataCollectable
    {
        $review = new ReviewDataCollectable();
        $review->setDataName($dataName);
        $review->setDataValue($dataValue);
        $review->setDisplayCondition($displayCondition);
        return $review;
    }
}