<?php

namespace App\Domain\State\Fixtures;

use App\Domain\Model\Administration\DataWizUser;
use App\Domain\Model\Study\Experiment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TestCaseFixtures extends Fixture
{
    private $testUserName;

    public function __construct()
    {
        $this->testUserName = "testcases@leibniz-psychology.org";
    }

    public function load(ObjectManager $manager)
    {
        $testUser = new DataWizUser($this->testUserName);
        $manager->persist($testUser);

        $testStudy = Experiment::createNewExperiment($testUser);
        $testStudy->getSettingsMetaDataGroup()->setShortName('Dummy Study');
        $manager->persist($testStudy);
        $manager->flush();
    }
}
