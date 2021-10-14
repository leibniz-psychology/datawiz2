<?php


namespace App\Review;


final class ReviewDataCollectable
{
    private string $dataName;
    private ?array $dataValue;
    private bool $displayCondition;
    private ?string $errorMessage;

    private function __construct()
    {
    }

    /**
     * @return string
     */
    public function getDataName(): string
    {
        return $this->dataName;
    }

    /**
     * @param string $dataName
     */
    public function setDataName(string $dataName): void
    {
        $this->dataName = $dataName;
    }

    /**
     * @return array|null
     */
    public function getDataValue(): ?array
    {
        return $this->dataValue;
    }

    /**
     * @param array|null $dataValue
     */
    public function setDataValue(?array $dataValue): void
    {
        $this->dataValue = $dataValue;
    }

    /**
     * @return bool
     */
    public function isDisplayCondition(): bool
    {
        return $this->displayCondition;
    }

    /**
     * @param bool $displayCondition
     */
    public function setDisplayCondition(bool $displayCondition): void
    {
        $this->displayCondition = $displayCondition;
    }

    /**
     * @return string|null
     */
    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    /**
     * @param string|null $errorMessage
     */
    public function setErrorMessage(?string $errorMessage): void
    {
        $this->errorMessage = $errorMessage;
    }


    public static function createFrom(string $dataName, ?array $dataValue, ?string $errorMessage = null, bool $displayCondition = true): ReviewDataCollectable
    {
        $review = new ReviewDataCollectable();
        $review->setDataName($dataName);
        $review->setDataValue($dataValue);
        $review->setDisplayCondition($displayCondition);
        $review->setErrorMessage($errorMessage);

        return $review;
    }
}