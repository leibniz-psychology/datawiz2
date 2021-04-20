<?php

namespace App\Domain\Definition\Study;

use Doctrine\ORM\Mapping as ORM;

trait Contactable
{
    /**
     * @ORM\Column(type="array", length=1500, nullable=true)
     * @var $contact array
     */
    private $contact;

    public function getContact(): ?array
    {
        if ($this->contact === null) {
            $this->contact = array('');
        }
        return $this->contact;
    }

    public function setContact(array $contact): void
    {
        $this->contact = $contact;
    }
}
