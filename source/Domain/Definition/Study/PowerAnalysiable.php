<?php


namespace App\Domain\Definition\Study;

// hopefully a real word
use Doctrine\ORM\Mapping as ORM;

trait PowerAnalysiable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $power_analysis;

    public function getPowerAnalysis()
    {
        return $this->power_analysis;
    }

    public function setPowerAnalysis($power_analysis): void
    {
        $this->power_analysis = $power_analysis;
    }
}