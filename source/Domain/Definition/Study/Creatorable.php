<?php

namespace App\Domain\Definition\Study;

use Doctrine\ORM\Mapping as ORM;

trait Creatorable
{
    /**
     * @ORM\Column(type="array", length=1500, nullable=true)
     * @var $creator array
     */
    private $creator;

    public function getCreator(): ?array
    {
        if ($this->creator === null) {
            $this->creator = array('');
        }
        return $this->creator;
    }

    public function setCreator(array $creator): void
    {
        $this->creator = $creator;
    }
}
