<?php

namespace App\Tests\Functional;

use App\Domain\Access\Administration\DataWizUserRepository;
use App\Domain\Access\Study\ExperimentRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class StudyControllerTest
 * This will check common functionality for the StudyController.
 */
class StudyFeatureTest extends WebTestCase
{
    private $client;
    private $tesStudyUuuid;

    public function setUp(): void
    {
        $this->client = static::createClient(); // get mock client for mock requests
        $userRepository = static::$container->get(DataWizUserRepository::class); // get repo to load user
        $testuser = $userRepository->findOneByEmail('testcases@leibniz-psychology.org'); // read the user for testing
        $this->client->loginUser($testuser); // authenticate the testuser for the testing
        $experimentRepository = static::$container->get(ExperimentRepository::class);
        $testStudy = $experimentRepository->findOneBy(array('owner' => $testuser));
        $this->tesStudyUuuid = $testStudy->getId();
    }

    /**
     * Testing every Action within it's own method is verbose and should be avoided
     * Better testing will be possible as soon as we can test a real workflow
     * The following tests should only break if a url gets changed - which is not trivial to circumvent.
     */
    public function testOverviewAction()
    {
        $this->client->request('GET', '/studies/overview');
        $this->assertResponseIsSuccessful();
    }

    public function testRootRedirect()
    {
        $this->client->request('GET', '/studies');
        $this->assertResponseRedirects();
    }

    public function testNewAction()
    {
        $this->client->request('GET', '/studies/new');
        $this->assertResponseIsSuccessful();
    }

    public function testSettingsAction()
    {
        $this->client->request('GET', '/studies/' . $this->tesStudyUuuid . '/settings');
        $this->assertResponseIsSuccessful();
    }

    public function testDocumentationAction()
    {
        $this->client->request('GET', '/studies/' . $this->tesStudyUuuid . '/documentation');
        $this->assertResponseIsSuccessful();
    }

    public function testTheoryAction()
    {
        $this->client->request('GET', '/studies/' . $this->tesStudyUuuid . '/theory');
        $this->assertResponseIsSuccessful();
    }

    public function testSampleAction()
    {
        $this->client->request('GET', '/studies/' . $this->tesStudyUuuid . '/sample');
        $this->assertResponseIsSuccessful();
    }

    public function testMeasureAction()
    {
        $this->client->request('GET', '/studies/' . $this->tesStudyUuuid . '/measure');
        $this->assertResponseIsSuccessful();
    }

    public function testMethodAction()
    {
        $this->client->request('GET', '/studies/' . $this->tesStudyUuuid . '/method');
        $this->assertResponseIsSuccessful();
    }

    public function testIntroductionAction()
    {
        $this->client->request('GET', '/studies/' . $this->tesStudyUuuid . '/introduction');
        $this->assertResponseIsSuccessful();
    }

    public function testMaterialsAction()
    {
        $this->client->request('GET', '/studies/' . $this->tesStudyUuuid . '/materials');
        $this->assertResponseIsSuccessful();
    }

    public function testDatasetsAction()
    {
        $this->client->request('GET', '/studies/' . $this->tesStudyUuuid . '/datasets');
        $this->assertResponseIsSuccessful();
    }

    public function testReviewAction()
    {
        $this->client->request('GET', '/review/' . $this->tesStudyUuuid);
        $this->assertResponseIsSuccessful();
    }

    // Not part of the study feature TODO: move to on test suit
    public function testProfileAction()
    {
        $this->client->request('GET', 'administration/profile');
        $this->assertResponseIsSuccessful();
    }

    public function testLandingAction()
    {
        $this->client->request('GET', 'administration/landing');
        $this->assertResponseIsSuccessful();
    }

    public function testDashboardAction()
    {
        $this->client->request('GET', 'administration/dashboard');
        $this->assertResponseIsSuccessful();
    }
}
