<?php

namespace App\Domain\Definition\Study;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait Assignable
 * @package App\Domain\Definition\Study
 *
 * Deprecated by domain expert and should be removed by 2022
 */
trait Assignable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $assignment;

    public function getAssignment()
    {
        return $this->assignment;
    }

    public function setAssignment($assignment): void
    {
        $this->assignment = $assignment;
    }
}
