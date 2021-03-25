<?php

namespace App\Domain\Definition\Study;

use Doctrine\ORM\Mapping as ORM;

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
