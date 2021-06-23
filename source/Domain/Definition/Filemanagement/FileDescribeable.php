<?php


namespace App\Domain\Definition\Filemanagement;


use Doctrine\ORM\Mapping as ORM;

trait FileDescribeable
{
    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     */
    private $fileDescription;

    public function getFileDescription()
    {
        return $this->fileDescription;
    }

    public function setFileDescription($fileDescription): void
    {
        $this->fileDescription = $fileDescription;
    }
}