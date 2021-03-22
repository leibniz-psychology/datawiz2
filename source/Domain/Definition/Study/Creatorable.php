<?php


namespace App\Domain\Definition\Study;


use Doctrine\ORM\Mapping as ORM;

trait Creatorable
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $creator;

    public function getCreator(): string
    {
        return $this->creator;
    }

    public function setCreator($creator): void
    {
        $this->creator = $creator;
    }

}