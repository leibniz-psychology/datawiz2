<?php


namespace App\Domain\Definition\Study;


use App\Questionnaire\FormInstructionValue;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\TextType;

trait Creatorable
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $creator;

    public function getCreator(): ?string
    {
        return $this->creator;
    }

    public function setCreator($creator): void
    {
        $this->creator = $creator;
    }
}