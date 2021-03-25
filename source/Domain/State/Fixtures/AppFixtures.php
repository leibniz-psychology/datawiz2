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
            'mc@leibniz-psychology.org',
            'fg@leibniz-psychology.org',
            'user1@datawiz.org',
            'user2@datawiz.org',
            'user3@datawiz.org',
            'user4@datawiz.org',
            'user5@datawiz.org',
            'user6@datawiz.org',
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
