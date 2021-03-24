<?php

namespace App\Domain\Model\Study;

use App\Domain\Access\Study\ExperimentRepository;
use App\Domain\Model\Administration\UuidEntity;
use App\Security\Authorization\Ownable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=ExperimentRepository::class)
 */
class Experiment extends UuidEntity implements Ownable
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Model\Administration\DataWizUser")
     */
    private $owner;

    /**
     * One Experiment has One Sample section.
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\SampleMetaDataGroup", mappedBy="experiment", cascade={"persist"})
     */
    private $sampleMetaDataGroup;

    /**
     * One Experiment has One Settings section.
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\SettingsMetaDataGroup", mappedBy="experiment", cascade={"persist"})
     */
    private $settingsMetaDataGroup;

    /**
     * One Experiment has One basic Information section.
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\BasicInformationMetaDataGroup", mappedBy="experiment", cascade={"persist"})
     */
    private $basicInformationMetaDataGroup;

    /**
     * One Experiment has One Theory section.
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\TheoryMetaDataGroup", mappedBy="experiment", cascade={"persist"})
     */
    private $theoryMetaDataGroup;

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    private function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getSampleMetaDataGroup()
    {
        return $this->sampleMetaDataGroup;
    }

    /**
     * @param mixed $sampleMetaDataGroup
     */
    public function setSampleMetaDataGroup(SampleMetaDataGroup $sampleMetaDataGroup): void
    {
        $this->sampleMetaDataGroup = $sampleMetaDataGroup;
        $sampleMetaDataGroup->setExperiment($this);
    }

    /**
     * @return mixed
     */
    public function getSettingsMetaDataGroup()
    {
        return $this->settingsMetaDataGroup;
    }

    /**
     * @param mixed $settingsMetaDataGroup
     */
    public function setSettingsMetaDataGroup(SettingsMetaDataGroup $settingsMetaDataGroup): void
    {
        $this->settingsMetaDataGroup = $settingsMetaDataGroup;
        $settingsMetaDataGroup->setExperiment($this);
    }

    /**
     * @return mixed
     */
    public function getBasicInformationMetaDataGroup()
    {
        return $this->basicInformationMetaDataGroup;
    }

    /**
     * @param mixed $basicInformationMetaDataGroup
     */
    public function setBasicInformationMetaDataGroup(BasicInformationMetaDataGroup $basicInformationMetaDataGroup): void
    {
        $this->basicInformationMetaDataGroup = $basicInformationMetaDataGroup;
        $basicInformationMetaDataGroup->setExperiment($this);
    }

    /**
     * @return mixed
     */
    public function getTheoryMetaDataGroup()
    {
        return $this->theoryMetaDataGroup;
    }

    /**
     * @param mixed $theoryMetaDataGroup
     */
    public function setTheoryMetaDataGroup(TheoryMetaDataGroup $theoryMetaDataGroup): void
    {
        $this->theoryMetaDataGroup = $theoryMetaDataGroup;
        $theoryMetaDataGroup->setExperiment($this);
    }

    public static function createNewExperiment(UserInterface $owner): Experiment
    {
        $newExperiment = new Experiment();
        $newExperiment->setSettingsMetaDataGroup(new SettingsMetaDataGroup());
        $newExperiment->setBasicInformationMetaDataGroup(new BasicInformationMetaDataGroup());
        $newExperiment->setTheoryMetaDataGroup(new TheoryMetaDataGroup());
        $newExperiment->setSampleMetaDataGroup(new SampleMetaDataGroup());
        $newExperiment->setOwner($owner);

        return $newExperiment;
    }
}
