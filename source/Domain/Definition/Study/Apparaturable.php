<?php


namespace App\Domain\Definition\Study;


use Doctrine\ORM\Mapping as ORM;

trait Apparaturable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $apparatus;

    public function getApparatus()
    {
        return $this->apparatus;
    }

    public function setApparatus($apparatus): void
    {
        $this->apparatus = $apparatus;
    }
}