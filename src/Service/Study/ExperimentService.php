<?php

namespace App\Service\Study;

use App\Entity\Administration\DataWizUser;
use App\Entity\Study\BasicInformationMetaDataGroup;
use App\Entity\Study\Experiment;
use App\Entity\Study\MeasureMetaDataGroup;
use App\Entity\Study\MethodMetaDataGroup;
use App\Entity\Study\SampleMetaDataGroup;
use App\Entity\Study\SettingsMetaDataGroup;
use App\Entity\Study\TheoryMetaDataGroup;

class ExperimentService
{
    public static function createNewExperiment(DataWizUser $owner): Experiment
    {
        $newExperiment = new Experiment();
        $newExperiment->setSettingsMetaDataGroup(new SettingsMetaDataGroup());
        $newExperiment->setBasicInformationMetaDataGroup(new BasicInformationMetaDataGroup());
        $newExperiment->setTheoryMetaDataGroup(new TheoryMetaDataGroup());
        $newExperiment->setSampleMetaDataGroup(new SampleMetaDataGroup());
        $newExperiment->setMeasureMetaDataGroup(new MeasureMetaDataGroup());
        $newExperiment->setMethodMetaDataGroup(new MethodMetaDataGroup());
        $newExperiment->setOwner($owner);

        return $newExperiment;
    }
}
