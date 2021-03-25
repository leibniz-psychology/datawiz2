<?php


namespace App\Domain\Definition\Study;


use Doctrine\ORM\Mapping as ORM;

trait Settable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $setting;

    public function getSetting()
    {
        return $this->setting;
    }

    public function setSetting($setting): void
    {
        $this->setting = $setting;
    }

}