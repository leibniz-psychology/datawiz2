<?php

namespace App\Domain\Definition\Study;

use Doctrine\ORM\Mapping as ORM;

trait Contactable
{
    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $contact;

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact($contact): void
    {
        $this->contact = $contact;
    }
}
