<?php

namespace App\Domain\Definition\Study;

use Doctrine\ORM\Mapping as ORM;

trait ExperimentalDesignable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $experimental_design;

    public function getExperimentalDesign()
    {
        return $this->experimental_design;
    }

    public function setExperimentalDesign($experimental_design): void
    {
        $this->experimental_design = $experimental_design;
    }
}
