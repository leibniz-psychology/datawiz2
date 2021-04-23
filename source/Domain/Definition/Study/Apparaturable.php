<?php

namespace App\Domain\Definition\Study;

use Doctrine\ORM\Mapping as ORM;

trait Apparaturable
{
    /**
     * @ORM\Column(type="array", length=1500, nullable=true)
     * @var $apparatus array
     */
    private $apparatus;

    public function getApparatus()
    {
        if ($this->apparatus === null) {
            $this->apparatus = array('');
        }
        return $this->apparatus;
    }

    public function setApparatus($apparatus): void
    {
        $this->apparatus = $apparatus;
    }
}
