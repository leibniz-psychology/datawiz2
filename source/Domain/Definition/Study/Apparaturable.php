<?php

namespace App\Domain\Definition\Study;

use Doctrine\ORM\Mapping as ORM;

trait Apparaturable
{
    /**
     * @ORM\Column(type="array", length=1500, nullable=true)
     * @var $apparatus array|null
     */
    private ?array $apparatus = null;

    public function getApparatus(): ?array
    {
        if ($this->apparatus === null) {
            $this->apparatus = array('');
        }

        return $this->apparatus;
    }

    public function setApparatus(?array $apparatus): void
    {
        $this->apparatus = array_values($apparatus);
    }
}
