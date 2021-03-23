<?php


namespace App\Domain\Definition\Study;


use Doctrine\ORM\Mapping as ORM;

trait Contactable
{
    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $contact;

    public function getContact()
    {
        return $this->contact;
    }

    public function setContact($contact): void
    {
        $this->contact = $contact;
    }

    private static function getContactOptions(): array
    {
        return [
            'label' => 'Contact',
            'help' => 'Please provide an Email Adress for further contact'
        ];
    }

}