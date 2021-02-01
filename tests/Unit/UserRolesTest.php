<?php

namespace App\Tests\Unit;

use App\Domain\Model\DataWizUser;
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

    public function testUserRoleFormat()
    {
        foreach ($this->normalUser->getRoles() as $role) {
            $this->assertStringStartsWith('ROLE_', $role);
        }

        foreach ($this->adminUser->getRoles() as $role) {
            $this->assertStringStartsWith('ROLE_', $role);
        }
    }

    public function testUserRoleInitialization()
    {
        $this->assertCount(1, $this->normalUser->getRoles());
        $this->assertCount(2, $this->adminUser->getRoles());
    }

    public function testUserRoleStrings()
    {
        $this->assertStringEndsWith('USER', $this->normalUser->getRoles()[0]);
        $this->assertStringEndsWith('ADMIN', $this->adminUser->getRoles()[1]);
    }

    public function testUserPromotion()
    {
        $this->normalUser->promotion();
        $this->assertCount(2, $this->normalUser->getRoles());
    }

    public function testUserDemotion()
    {
        $this->adminUser->demotion();
        $this->assertCount(1, $this->normalUser->getRoles());
    }
}
