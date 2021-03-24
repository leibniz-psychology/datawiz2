<?php

namespace App\Tests\Integration;

use App\Domain\Model\Study\SettingsMetaDataGroup;
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
            ->formFromEntity(new SettingsMetaDataGroup(), 'save');

        $this->assertNotEmpty($form);
        $this->assertInstanceOf(FormInterface::class, $form);
    }

    public function testCreateAndHanleFormReturnsForm()
    {
        $form = $this->questionnaire
            ->askAndHandle(new SettingsMetaDataGroup(), 'save', new Request());

        $this->assertNotEmpty($form);
        $this->assertInstanceOf(FormInterface::class, $form);
    }

    public function testSubmittedAndValidReturnsFalseWhenDataIsMissing()
    {
        $form = $this->questionnaire
            ->askAndHandle(new SettingsMetaDataGroup(), 'save', new Request());

        $this->assertFalse($this->questionnaire->isSubmittedAndValid($form));
    }
}
