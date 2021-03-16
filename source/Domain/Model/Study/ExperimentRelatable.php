<?php


namespace App\Domain\Model\Study;


trait ExperimentRelatable
{
    protected $experiment;

    public function getExperiment(): Experiment
    {
        return $this->experiment;
    }

    public function setExperiment(Experiment $experiment): void
    {
        $this->experiment = $experiment;
    }

}