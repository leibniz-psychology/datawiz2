<?php


namespace App\Domain\Definition\Study;


use App\Questionnaire\FormInstructionValue;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

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

    private static function getContactOptions(): FormInstructionValue
    {
        return new FormInstructionValue(TextareaType::class, [
            'label' => 'Contact',
            'help' => 'Please provide an Email Adress for further contact'
        ]);
    }

}