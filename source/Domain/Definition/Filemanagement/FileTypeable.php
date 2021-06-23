<?php


namespace App\Domain\Definition\Filemanagement;


use Doctrine\ORM\Mapping as ORM;

trait FileTypeable
{
    /**
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private $fileType;

    public function getFileType()
    {
        return $this->fileType;
    }

    public function setFileType($fileType): void
    {
        $this->fileType = $fileType;
    }
}