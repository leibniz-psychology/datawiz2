<?php

declare(strict_types=1);

namespace App\Twig\Components\Form\DataManagementPlan;

use App\Entity\DataManagementPlan\DmpEthicalLegal;
use App\Form\DataManagementPlan\DmpEthicalLegalType;
use App\Repository\DataManagementPlan\DmpEthicalLegalRepository;
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
class DmpEthicalLegalForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use DataManagementPlanFormTrait;

    public const string formType = 'ethicalLegal';

    #[LiveProp]
    public ?DmpEthicalLegal $initialFormData = null;

    public function __construct(
        private readonly DmpEthicalLegalRepository $ethicalLegalRepository,
    ) {
    }

    #[LiveAction]
    public function save(#[LiveArg] ?string $route): ?Response
    {
        $this->submitForm();
        /** @var DmpEthicalLegal $ethicalLegal */
        $ethicalLegal = $this->getForm()->getData();

        $this->ethicalLegalRepository->save($ethicalLegal);
        if (!is_null($route)) {
            return $this->redirectToRoute($route, [
                'id' => $ethicalLegal->getDataManagementPlan()->getId(),
            ]);
        }

        return $this->redirectToRoute('Dmp-edit-ethical-legal', ['id' => $ethicalLegal->getDataManagementPlan()->getId()]);
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(DmpEthicalLegalType::class, $this->initialFormData);
    }
}
