<?php

namespace App\Tests\Functional;

use App\Domain\Access\Administration\DataWizUserRepository;
use App\Domain\Model\Administration\DataWizUser;
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
        $this->client = static::createClient(); // get mock client for mock requests
        $userRepository = static::$container->get(DataWizUserRepository::class); // get repo to load user
        $testuser = $userRepository->findOneByEmail('mc@leibniz-psychology.org'); // read the user for testing
        $this->client->loginUser($testuser); // authenticate the testuser for the testing
    }

    /**
     * Testing every Action within it's own method is verbose and should be avoided
     * Better testing will be possible as soon as we can test a real workflow
     * The following tests should only break if a url gets changed - which is not trivial to circumvent.
     */
    public function testOverviewAction()
    {
        $this->client->request('GET', '/pages/studies/overview');
        $this->assertResponseIsSuccessful();
    }

    public function testRootRedirect()
    {
        $this->client->request('GET', '/pages/studies');
        $this->assertResponseRedirects();
    }

    public function testNewAction()
    {
        $this->client->request('GET', '/pages/studies/new');
        $this->assertResponseIsSuccessful();
    }
/*
    public function testDocumentationAction()
    {

        $this->client->request('GET', '/pages/studies/22b7a92f-9338-4f25-9fb6-eec52e64b43d/documentation');
        $this->assertResponseIsSuccessful();
    }

    public function testAdminAction()
    {
        $this->client->request('GET', '/pages/studies/admin');
        $this->assertResponseIsSuccessful();
    }

    public function testDesignAction()
    {
        $this->client->request('GET', '/pages/studies/design');
        $this->assertResponseIsSuccessful();
    }

    public function testTheoryAction()
    {
        $this->client->request('GET', '/pages/studies/theory');
        $this->assertResponseIsSuccessful();
    }

    public function testSampleAction()
    {
        $this->client->request('GET', '/pages/studies/sample');
        $this->assertResponseIsSuccessful();
    }*/
}
