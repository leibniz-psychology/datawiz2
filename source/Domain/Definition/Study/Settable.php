<?php

namespace App\Domain\Definition\Study;

use Doctrine\ORM\Mapping as ORM;

trait Settable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $setting;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $setting_location;

    public function getSetting()
    {
        return $this->setting;
    }

    public function setSetting($setting): void
    {
        $this->setting = $setting;
    }

    public function getSettingLocation()
    {
        return $this->setting_location;
    }

    public function setSettingLocation($otherSetting): void
    {
        $this->setting_location = $otherSetting;

    }
}
