<?php

namespace App\Domain\Fixtures;


use App\Domain\Model\DataWizUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new DataWizUser('dummy');
        $manager->persist($user);

        $manager->flush();
    }
}
