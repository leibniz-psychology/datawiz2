<?php

namespace App\Domain\Definition\Study;

use Doctrine\ORM\Mapping as ORM;

trait ResearchDesignable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $research_design;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $experimental_details;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $non_experimental_details;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $observational_type;


    public function getResearchDesign()
    {
        return $this->research_design;
    }

    public function getDesignDetails()
    {
        if ($this->research_design === "Experimental") {
            return $this->experimental_details;
        }
        elseif ($this->research_design === "Non-Experimental") {
            return $this->non_experimental_details;
        } else {
            return null;
        }
    }

    public function setResearchDesign($research_design): void
    {
        $this->research_design = $research_design;
    }

    public function getExperimentalDetails()
    {
        return $this->experimental_details;
    }

    public function setExperimentalDetails($experimental_details): void
    {
        $this->experimental_details = $experimental_details;
    }

    public function getNonExperimentalDetails()
    {
        return $this->non_experimental_details;
    }

    public function setNonExperimentalDetails($non_experimental_details): void
    {
        $this->non_experimental_details = $non_experimental_details;
    }

    public function getObservationalType()
    {
        return $this->observational_type;
    }

    public function setObservationalType($observational_type): void
    {
        $this->observational_type = $observational_type;
    }

}
