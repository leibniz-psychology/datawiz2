<?php


namespace App\Domain\Definition\Study;


use Doctrine\ORM\Mapping as ORM;

trait Descriptable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $description;

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

}