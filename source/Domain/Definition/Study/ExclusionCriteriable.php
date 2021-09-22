<?php

namespace App\Domain\Definition\Study;

use Doctrine\ORM\Mapping as ORM;

trait ExclusionCriteriable
{
    /**
     * @ORM\Column(type="array", length=1500, nullable=true)
     */
    private ?array $exclusion_criteria = null;

    public function getExclusionCriteria(): ?array
    {
        if ($this->exclusion_criteria === null) {
            $this->exclusion_criteria = array('');
        }

        return $this->exclusion_criteria;
    }

    public function setExclusionCriteria(?array $exclusion_criteria): void
    {
        $this->exclusion_criteria = array_values($exclusion_criteria);
    }
}
