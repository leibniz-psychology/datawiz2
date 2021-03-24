<?php


namespace App\Domain\Definition\Study;


use App\Questionnaire\FormInstructionValue;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

trait Titleable
{
    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $title;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }
}