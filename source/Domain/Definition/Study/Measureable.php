<?php

namespace App\Domain\Definition\Study;

use Doctrine\ORM\Mapping as ORM;

trait Measureable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $measures;

    public function getMeasures()
    {
        return $this->measures;
    }

    public function setMeasures($measures): void
    {
        $this->measures = $measures;
    }
}
