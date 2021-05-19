<?php


namespace App\Domain\Definition\Filemanagement;


use Doctrine\ORM\Mapping as ORM;

trait AtUploadNameable
{
    /**
     * @ORM\Column() (type="string", length=256, nullable=true)
     */
    private $atUploadNameable;

    /**
     * @return mixed
     */
    public function getAtUploadNameable()
    {
        return $this->atUploadNameable;
    }

    /**
     * @param mixed $atUploadNameable
     */
    public function setAtUploadNameable($atUploadNameable): void
    {
        $this->atUploadNameable = $atUploadNameable;
    }



}