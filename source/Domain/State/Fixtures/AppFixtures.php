<?php

namespace App\Domain\State\Fixtures;

use App\Domain\Model\Administration\DataWizUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private $testUserNames;

    public function __construct()
    {
        $this->testUserNames = [
            'user@leibniz-psychology.org',
            'foo@leibniz-psychology.org',
            'bar@leibniz-psychology.org',
        ];
    }

    public function load(ObjectManager $manager)
    {
        $this->createTestUser($manager);
        $manager->flush();
    }

    public function createTestUser(ObjectManager $manager)
    {
        foreach ($this->testUserNames as $userName) {
            $manager->persist(new DataWizUser($userName));
        }
    }
}
