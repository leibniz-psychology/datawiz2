<?php

declare(strict_types=1);

namespace App\Twig\Components\Form\DataManagementPlan;

use App\Entity\DataManagementPlan\DmpResearchData;
use App\Form\DataManagementPlan\DmpResearchDataType;
use App\Repository\DataManagementPlan\DmpResearchDataRepository;
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
class DmpResearchDataForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use DataManagementPlanFormTrait;

    public const string formType = 'researchData';

    #[LiveProp]
    public ?DmpResearchData $initialFormData = null;

    public function __construct(
        private readonly DmpResearchDataRepository $researchDataRepository,
    ) {
    }

    #[LiveAction]
    public function save(#[LiveArg] ?string $route): ?Response
    {
        $this->submitForm();
        /** @var DmpResearchData $researchData */
        $researchData = $this->getForm()->getData();

        $this->researchDataRepository->save($researchData);
        if (!is_null($route)) {
            return $this->redirectToRoute($route, [
                'id' => $researchData->getDataManagementPlan()->getId(),
            ]);
        }

        return $this->redirectToRoute('Dmp-edit-research-data', ['id' => $researchData->getDataManagementPlan()->getId()]);
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(DmpResearchDataType::class, $this->initialFormData);
    }
}
