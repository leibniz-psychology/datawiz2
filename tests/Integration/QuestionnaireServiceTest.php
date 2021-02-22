<?php

namespace App\Tests\Integration;

use App\Questionnaire\Forms\StudySettingsType;
use App\Questionnaire\Questionable;
use App\Questionnaire\QuestionnaireService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class QuestionnaireServiceTest extends KernelTestCase
{
    /**
     * @var Questionable
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
            ->createForm(StudySettingsType::class);

        $this->assertNotEmpty($form);
        $this->assertInstanceOf(FormInterface::class, $form);
    }

    public function testCreateAndHanleFormReturnsForm()
    {
        $form = $this->questionnaire
            ->createAndHandleForm(StudySettingsType::class, new Request());

        $this->assertNotEmpty($form);
        $this->assertInstanceOf(FormInterface::class, $form);
    }

    public function testSubmittedAndValidReturnsFalseWhenDataIsMissing()
    {
        $form = $this->questionnaire
            ->createAndHandleForm(StudySettingsType::class, new Request());

        $this->assertFalse($this->questionnaire->submittedAndValid($form));
    }
}
