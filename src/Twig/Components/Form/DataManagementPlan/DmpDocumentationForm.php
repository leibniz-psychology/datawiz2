<?php

declare(strict_types=1);

namespace App\Twig\Components\Form\DataManagementPlan;

use App\Entity\DataManagementPlan\DmpDocumentation;
use App\Form\DataManagementPlan\DmpDocumentationType;
use App\Repository\DataManagementPlan\DmpDocumentationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class DmpDocumentationForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use DataManagementPlanFormTrait;

    public const string formType = 'documentation';

    #[LiveProp]
    public ?DmpDocumentation $initialFormData = null;

    public function __construct(
        private readonly DmpDocumentationRepository $documentationRepository,
    ) {
    }

    #[LiveAction]
    public function save(#[LiveArg] ?string $route): ?Response
    {
        $this->submitForm();
        /** @var DmpDocumentation $documentation */
        $documentation = $this->getForm()->getData();

        $this->documentationRepository->save($documentation);
        if (!is_null($route)) {
            return $this->redirectToRoute($route, [
                'id' => $documentation->getDataManagementPlan()->getId(),
            ]);
        }

        return $this->redirectToRoute('Dmp-edit-documentation', ['id' => $documentation->getDataManagementPlan()->getId()]);
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(DmpDocumentationType::class, $this->initialFormData);
    }
}
