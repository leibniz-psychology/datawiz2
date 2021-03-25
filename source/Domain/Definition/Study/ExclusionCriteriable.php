<?php


namespace App\Domain\Definition\Study;


use Doctrine\ORM\Mapping as ORM;

trait ExclusionCriteriable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $exclusion_criteria;

    public function getExclusionCriteria()
    {
        return $this->exclusion_criteria;
    }

    public function setExclusionCriteria($exclusion_criteria): void
    {
        $this->exclusion_criteria = $exclusion_criteria;
    }
}