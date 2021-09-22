<?php

namespace App\Domain\Definition\Study;

use Doctrine\ORM\Mapping as ORM;

trait InclusionCriteriable
{
    /**
     * @ORM\Column(type="array", length=1500, nullable=true)
     */
    private ?array $inclusion_criteria = null;

    public function getInclusionCriteria(): ?array
    {
        if ($this->inclusion_criteria === null) {
            $this->inclusion_criteria = array('');
        }

        return $this->inclusion_criteria;
    }

    public function setInclusionCriteria(?array $inclusion_criteria): void
    {
        $this->inclusion_criteria = array_values($inclusion_criteria);
    }
}
