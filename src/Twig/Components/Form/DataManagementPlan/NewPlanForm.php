<?php

namespace App\Twig\Components\Form\DataManagementPlan;

use App\Controller\BaseController;
use App\Entity\DataManagementPlan\DmpAdministrativeData;
use App\Form\DataManagementPlan\DmpNewType;
use App\Repository\DataManagementPlan\DataManagementPlanRepository;
use App\Service\DataManagementPlan\DataManagementPlanService;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class NewPlanForm extends BaseController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp]
    public ?DmpAdministrativeData $initialFormData = null;

    public function __construct(
        private readonly DataManagementPlanRepository $dataManagementPlanRepository,
        private readonly DataManagementPlanService $dataManagementService,
    ) {
    }

    #[LiveAction]
    public function save(): ?Response
    {
        $this->submitForm();
        /** @var DmpAdministrativeData $administrativeData */
        $administrativeData = $this->getForm()->getData();

        $newDataManagementPlan = $this->dataManagementService->createNewDataManagementPlan($this->getUser());
        $newDataManagementPlan->setAdministrativeData($administrativeData);
        $administrativeData->setDataManagementPlan($newDataManagementPlan);

        $this->dataManagementPlanRepository->save($newDataManagementPlan);

        return $this->redirectToRoute('Dmp-introduction', ['id' => $newDataManagementPlan->getId()]);
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(DmpNewType::class, $this->initialFormData);
    }
}
