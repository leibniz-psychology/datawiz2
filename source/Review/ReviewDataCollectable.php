<?php


namespace App\Review;


final class ReviewDataCollectable
{
    private $dataName;
    private $dataValue;
    private $templateName;

    /**
     * @var $displayCondition \Closure
     */
    private $displayCondition;

    private const COMPONENT_PREFIX = "Components/_";
    private const TEMPLATE_SUFFIX = ".html.twig";

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

    public function getTemplateName()
    {
        return $this->templateName;
    }

    public function setTemplateName($templateName): void
    {
        $this->templateName =
            ReviewDataCollectable::COMPONENT_PREFIX
            . $templateName
            . ReviewDataCollectable::TEMPLATE_SUFFIX;
    }

    public static function createEmpty(): ReviewDataCollectable
    {
        return new ReviewDataCollectable();
    }

    public static function createFrom(string $dataName, $dataValue, \Closure $displayCondition, string $templateName): ReviewDataCollectable
    {
        $review = new ReviewDataCollectable();
        $review->setDataName($dataName);
        $review->setDataValue($dataValue);
        $review->setDisplayCondition($displayCondition);
        $review->setTemplateName($templateName);
        return $review;
    }
}