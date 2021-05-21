<?php


namespace App\Domain\Definition\Filemanagement;


use Doctrine\ORM\Mapping as ORM;

trait StorageNameable
{
    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     */
    private $storageName;

    public function getStorageName()
    {
        return $this->storageName;
    }

    public function setStorageName($storageName): void
    {
        $this->storageName = $storageName;
    }

}