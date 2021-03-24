<?php

namespace App\Tests\Integration;

use App\Questionnaire\Forms\SettingsType;
use App\Questionnaire\Questionnairable;
use App\Questionnaire\QuestionnaireService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class QuestionnaireServiceTest extends KernelTestCase
{
    /**
     * @var Questionnairable
     */
    private $questionnaire;

    protected function setUp(): void
    {
        $this->questionnaire = self::bootKernel()
            ->getContainer()
            ->get('test.service_container')
            ->get(QuestionnaireService::class);
    }

    public function testCreateFormReturnsForm()
    {
        $form = $this->questionnaire
            ->createForm(SettingsType::class);

        $this->assertNotEmpty($form);
        $this->assertInstanceOf(FormInterface::class, $form);
    }

    public function testCreateAndHanleFormReturnsForm()
    {
        $form = $this->questionnaire
            ->createAndHandleForm(SettingsType::class, new Request());

        $this->assertNotEmpty($form);
        $this->assertInstanceOf(FormInterface::class, $form);
    }

    public function testSubmittedAndValidReturnsFalseWhenDataIsMissing()
    {
        $form = $this->questionnaire
            ->createAndHandleForm(SettingsType::class, new Request());

        $this->assertFalse($this->questionnaire->submittedAndValid($form));
    }
}
