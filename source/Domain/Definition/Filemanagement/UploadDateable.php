<?php


namespace App\Domain\Definition\Filemanagement;


use Doctrine\ORM\Mapping as ORM;

trait UploadDateable
{
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $uploadDate;

    public function getUploadDate()
    {
        return $this->uploadDate;
    }

    public static function getCurrentDate()
    {
        // The timezone value should be come from our servers php settings (described as current timezone)
        return new \DateTime("now");
    }
}