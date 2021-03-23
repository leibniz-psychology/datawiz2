<?php


namespace App\Domain\Definition\Study;


use App\Questionnaire\FormInstructionValue;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Form;

trait Descriptable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $description;

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    private static function getDescriptionOptions(): FormInstructionValue
    {
        return new FormInstructionValue(TextareaType::class, [
            'label' => 'Creator',
            'help' => 'Person who created this study'
        ]);
    }

}