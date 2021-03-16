<?php

namespace App\Tests\Unit;

use App\Domain\Model\Administration\DataWizUser;
use PHPUnit\Framework\TestCase;

class UserSettingsTest extends TestCase
{
    private $normalUser;

    protected function setUp(): void
    {
        $this->normalUser = new DataWizUser('someone@gmail.com');
    }

    public function testUserSettingsAreSet()
    {
        $this->assertNotEmpty($this->normalUser->getDatawizSettings());
    }
}
