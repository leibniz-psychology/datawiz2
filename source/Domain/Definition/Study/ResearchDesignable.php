<?php


namespace App\Domain\Definition\Study;


use Doctrine\ORM\Mapping as ORM;

trait ResearchDesignable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $research_design;

    public function getResearchDesign()
    {
        return $this->research_design;
    }

    public function setResearchDesign($research_design): void
    {
        $this->research_design = $research_design;
    }

}