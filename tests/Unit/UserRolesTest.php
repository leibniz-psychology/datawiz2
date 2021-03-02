<?php

namespace App\Tests\Unit;

use App\Domain\Model\Administration\DataWizUser;
use PHPUnit\Framework\TestCase;

class UserRolesTest extends TestCase
{
    private $normalUser;
    private $adminUser;

    protected function setUp(): void
    {
        $this->normalUser = new DataWizUser('D3FF720E-DF50-4C56-9572-8CD06B011EA2');
        $this->adminUser = new DataWizUser('D3FF720E-DF50-4C56-9572-8CD06B011EA2', true);
    }

    /**
     * Expects all toles to start with ROLE_.
     */
    public function testUserRoleFormat()
    {
        foreach ($this->normalUser->getRoles() as $role) {
            $this->assertStringStartsWith('ROLE_', $role);
        }

        foreach ($this->adminUser->getRoles() as $role) {
            $this->assertStringStartsWith('ROLE_', $role);
        }
    }

    /**
     * Will a new user have correct roles from the start?
     */
    public function testUserRoleInitialization()
    {
        $this->assertCount(1, $this->normalUser->getRoles());
        $this->assertCount(2, $this->adminUser->getRoles());
    }

    /**
     * Test for all valid roles if there are useable.
     */
    public function testUserRoleStrings()
    {
        $this->assertStringEndsWith('USER', $this->normalUser->getRoles()[0]);
        $this->assertStringEndsWith('ADMIN', $this->adminUser->getRoles()[1]);
    }

    /**
     * Can a normal user become admin?
     */
    public function testUserPromotion()
    {
        $this->normalUser->promotion();
        $this->assertCount(2, $this->normalUser->getRoles());
    }

    /**
     * Can an admin become a normal user again?
     */
    public function testUserDemotion()
    {
        $this->adminUser->demotion();
        $this->assertCount(1, $this->adminUser->getRoles());
    }

    /**
     * Do we leak our roles array by accident?
     */
    public function testIfRolesAreImmutableFromOutside()
    {
        $roles = $this->normalUser->getRoles(); // has one from init
        $roles[] = 'admin'; // add one
        $roles[] = 'hacker'; // add two - invalid one

        $this->assertCount(3, $roles);
        $this->assertCount(1, $this->normalUser->getRoles());
    }
}
