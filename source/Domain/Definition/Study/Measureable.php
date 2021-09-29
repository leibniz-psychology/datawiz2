<?php

namespace App\Domain\Definition\Study;

use Doctrine\ORM\Mapping as ORM;

trait Measureable
{
    /**
     * @ORM\Column(type="array", length=1500, nullable=true)
     * @var $measures array|null
     */
    private ?array $measures = null;

    public function getMeasures(): ?array
    {
        if ($this->measures === null) {
            $this->measures = array('');
        }

        return $this->measures;
    }

    public function setMeasures(?array $measures): void
    {
        $this->measures = array_values($measures);
    }
}
