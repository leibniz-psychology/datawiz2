<?php

namespace App\Domain\Definition\Study;

use Doctrine\ORM\Mapping as ORM;

trait ControlOperationable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $control_operations;

    public function getControlOperations()
    {
        return $this->control_operations;
    }

    public function setControlOperations($control_operations): void
    {
        $this->control_operations = $control_operations;
    }
}
