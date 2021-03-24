<?php


namespace App\Domain\Definition\Study;


use App\Questionnaire\FormInstructionValue;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\TextType;

trait ShortNameable
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $short_name;

    public function getShortName(): ?string
    {
        return $this->short_name;
    }

    public function setShortName(string $newShortName): void
    {
        $this->short_name = $newShortName;
    }
}