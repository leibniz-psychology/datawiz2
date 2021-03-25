<?php

namespace App\Domain\Definition\Study;

use Doctrine\ORM\Mapping as ORM;

trait Objectivable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $objective;

    public function getObjective()
    {
        return $this->objective;
    }

    public function setObjective($objective): void
    {
        $this->objective = $objective;
    }
}
