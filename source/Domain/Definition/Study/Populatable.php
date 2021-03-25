<?php

namespace App\Domain\Definition\Study;

use Doctrine\ORM\Mapping as ORM;

trait Populatable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $population;

    public function getPopulation()
    {
        return $this->population;
    }

    public function setPopulation($population): void
    {
        $this->population = $population;
    }
}
