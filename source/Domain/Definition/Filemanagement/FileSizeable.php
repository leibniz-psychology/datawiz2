<?php


namespace App\Domain\Definition\Filemanagement;


use Doctrine\ORM\Mapping as ORM;

trait FileSizeable
{
    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     */
    private $fileSize;

    public function getFileSize()
    {
        return $this->fileSize;
    }

    public function setFileSize($fileSize): void
    {
        $this->fileSize = $fileSize;
    }

}