<?php


namespace App\Review;


final class ReviewDataCollectable
{
    private string $dataName;
    private ?array $dataValue = null;
    private ?bool $displayCondition = null;
    private ?string $errorMessage = null;
    private ?string $errorType = null;

    private function __construct()
    {
    }

    public function getDataName(): string
    {
        return $this->dataName;
    }

    public function setDataName(string $dataName): void
    {
        $this->dataName = $dataName;
    }

    public function getDataValue(): ?array
    {
        return $this->dataValue;
    }

    public function setDataValue(?array $dataValue): void
    {
        $this->dataValue = $dataValue;
    }

    public function isDisplayCondition(): bool
    {
        return $this->displayCondition;
    }

    public function setDisplayCondition(bool $displayCondition): void
    {
        $this->displayCondition = $displayCondition;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    public function setErrorMessage(?string $errorMessage): void
    {
        $this->errorMessage = $errorMessage;
    }

    public function getErrorType(): ?string
    {
        return $this->errorType;
    }

    public function setErrorType(?string $errorType): void
    {
        $this->errorType = $errorType;
    }


    public static function createFrom(array $reviewData, ?array $dataValue, bool $valid = false, bool $displayCondition = true): ReviewDataCollectable
    {
        $review = new ReviewDataCollectable();
        $review->setDataName($reviewData['legend']);
        $review->setDataValue($dataValue);
        $review->setDisplayCondition($displayCondition);
        if (!$valid) {
            $review->setErrorMessage($reviewData['errorMsg']);
            $review->setErrorType($reviewData['errorLevel']);
        }

        return $review;
    }
}