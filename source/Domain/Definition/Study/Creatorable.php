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
        return $this->creator;
    }

    public function setCreator(array $creator): void
    {
        $this->creator = $creator;
    }

    private function initializeCreator(): void
    {
        // prevent accidental overrides
        if ($this->creator === null) {
            // The empty string is needed to display the first form
            $this->creator = array('');
        }
    }
}
