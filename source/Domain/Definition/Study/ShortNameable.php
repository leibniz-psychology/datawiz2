<?php


namespace App\Domain\Definition\Study;


use Doctrine\ORM\Mapping as ORM;

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

    private static function getShortNameOptions(): array
    {
        return [
            'label' => 'Short name:',
            'help' => 'Shorter name than your title. For internal reference only.'
        ];
    }
}