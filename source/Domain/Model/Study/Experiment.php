<?php


namespace App\Domain\Model\Study;


use App\Domain\Model\Administration\UuidEntity;
use App\Domain\Access\Study\ExperimentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExperimentRepository::class)
 */
class Experiment extends UuidEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Model\Administration\DataWizUser")
     * @ORM\JoinColumn(name="user_uuid", referencedColumnName="uuid")
     */
    private $owner;

    /**
     * One Experiment has One Sample section.
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\SampleMetaDataGroup", mappedBy="uuid", cascade={"persist"})
     * @ORM\JoinColumn(name="sample_meta_data_uuid", referencedColumnName="uuid")
     */
    private $sampleMetaDataGroup;

    /**
     * One Experiment has One Settings section.
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\SettingsMetaDataGroup", mappedBy="uuid", cascade={"persist"})
     * @ORM\JoinColumn(name="settings_meta_data_uuid", referencedColumnName="uuid")
     */
    private $settingsMetaDataGroup;

    /**
     * One Experiment has One basic Information section.
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\BasicInformationMetaDataGroup", mappedBy="uuid", cascade={"persist"})
     * @ORM\JoinColumn(name="basic_information_meta_data_uuid", referencedColumnName="uuid")
     */
    private $basicInformationMetaDataGroup;

    /**
     * One Experiment has One Theory section.
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\TheoryMetaDataGroup", mappedBy="uuid", cascade={"persist"})
     * @ORM\JoinColumn(name="theory_meta_data_uuid", referencedColumnName="uuid")
     */
    private $theoryMetaDataGroup;

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
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

    public static function createNewExperiment(): Experiment
    {
        $newExperiment = new Experiment();
        $newExperiment->setSettingsMetaDataGroup(new SettingsMetaDataGroup());
        $newExperiment->setBasicInformationMetaDataGroup(new BasicInformationMetaDataGroup());
        $newExperiment->setTheoryMetaDataGroup(new TheoryMetaDataGroup());
        $newExperiment->setSampleMetaDataGroup(new SampleMetaDataGroup());

        return $newExperiment;
    }


}