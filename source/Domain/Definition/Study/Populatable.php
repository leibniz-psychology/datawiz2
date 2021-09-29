<?php

namespace App\Domain\Definition\Study;

use Doctrine\ORM\Mapping as ORM;

trait Populatable
{
    /**
     * @ORM\Column(type="array", length=1500, nullable=true)
     */
    private ?array $population = null;

    public function getPopulation(): ?array
    {
        if ($this->population === null) {
            $this->population = array('');
        }

        return $this->population;
    }

    public function setPopulation(?array $population): void
    {
        $this->population = array_values($population);
    }
}
