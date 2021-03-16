<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class StudyControllerTest
 * This will check common functionality for the StudyController.
 */
class StudyFeatureTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * Testing every Action within it's own method is verbose and should be avoided
     * Better testing will be possible as soon as we can test a real workflow
     * The following tests should only break if a url gets changed - which is not trivial to circumvent.
     */
    public function testOverviewAction()
    {
        $this->client->request('GET', '/pages/studies/overview');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testRootRedirect()
    {
        $this->client->request('GET', '/pages/studies');
        $this->assertEquals(301, $this->client->getResponse()->getStatusCode());
    }

    public function testNewAction()
    {
        $this->client->request('GET', '/pages/studies/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testDocumentationAction()
    {
        $this->client->request('GET', '/pages/studies/documentation');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminAction()
    {
        $this->client->request('GET', '/pages/studies/admin');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testDesignAction()
    {
        $this->client->request('GET', '/pages/studies/design');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testTheoryAction()
    {
        $this->client->request('GET', '/pages/studies/theory');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testSampleAction()
    {
        $this->client->request('GET', '/pages/studies/sample');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
