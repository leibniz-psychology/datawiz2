<?php


namespace App\Domain\Definition\Study;


use Doctrine\ORM\Mapping as ORM;

trait Participanable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $participants;

    public function getParticipants()
    {
        return $this->participants;
    }

    public function setParticipants($participants): void
    {
        $this->participants = $participants;
    }
}