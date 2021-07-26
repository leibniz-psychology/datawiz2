<?php

namespace App\Domain\Definition\Study;

use Doctrine\ORM\Mapping as ORM;

trait Populatable
{
    /**
     * @ORM\Column(type="array", length=1500, nullable=true)
     */
    private $population;

    public function getPopulation()
    {
        if ($this->population === null) {
            $this->population = array('');
        }
        return $this->population;
    }

    public function setPopulation($population): void
    {
        $this->population = $population;
    }
}
