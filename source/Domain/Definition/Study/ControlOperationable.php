<?php

namespace App\Domain\Definition\Study;

use Doctrine\ORM\Mapping as ORM;

trait ControlOperationable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $control_operations;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $other_control_operations;

    public function getControlOperations()
    {
        if ($this->control_operations === "Others")
            $answer = $this->other_control_operations;
        else {
            $answer = $this->control_operations;
        }

        return $answer;
    }

    public function setControlOperations($control_operations): void
    {
        $this->control_operations = $control_operations;
    }

    public function getOtherControlOperations()
    {
        return $this->other_control_operations;
    }

    public function setOtherControlOperations($other_control_operations): void
    {
        $this->other_control_operations = $other_control_operations;
    }

}
