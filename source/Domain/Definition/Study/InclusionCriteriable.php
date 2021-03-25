<?php


namespace App\Domain\Definition\Study;


use Doctrine\ORM\Mapping as ORM;

trait InclusionCriteriable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $inclusion_criteria;

    public function getInclusionCriteria()
    {
        return $this->inclusion_criteria;
    }

    public function setInclusionCriteria($inclusion_criteria): void
    {
        $this->inclusion_criteria = $inclusion_criteria;
    }

}