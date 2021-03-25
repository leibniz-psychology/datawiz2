<?php


namespace App\Domain\Definition\Study;


use Doctrine\ORM\Mapping as ORM;

trait Manipulatable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $manipulations;

    public function getManipulations()
    {
        return $this->manipulations;
    }

    public function setManipulations($manipulations): void
    {
        $this->manipulations = $manipulations;
    }

}