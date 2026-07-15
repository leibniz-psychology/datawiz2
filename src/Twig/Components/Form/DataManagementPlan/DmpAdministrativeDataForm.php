<?php

declare(strict_types=1);

namespace App\Twig\Components\Form\DataManagementPlan;

use App\Entity\DataManagementPlan\DmpAdministrativeData;
use App\Form\DataManagementPlan\DmpAdministrativeDataType;
use App\Repository\DataManagementPlan\DmpAdministrativeDataRepository;
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
class DmpAdministrativeDataForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use DataManagementPlanFormTrait;

    public const string formType = 'administrativeData';

    #[LiveProp]
    public ?DmpAdministrativeData $initialFormData = null;

    public function __construct(
        private readonly DmpAdministrativeDataRepository $administrativeDataRepository,
    ) {
    }

    #[LiveAction]
    public function save(#[LiveArg] ?string $route): ?Response
    {
        $this->submitForm();
        /** @var DmpAdministrativeData $administrativeData */
        $administrativeData = $this->getForm()->getData();

        $this->administrativeDataRepository->save($administrativeData);
        if (!is_null($route)) {
            return $this->redirectToRoute($route, [
                'id' => $administrativeData->getDataManagementPlan()->getId(),
            ]);
        }

        return $this->redirectToRoute('Dmp-edit-administrative', ['id' => $administrativeData->getDataManagementPlan()->getId()]);
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(DmpAdministrativeDataType::class, $this->initialFormData);
    }
}
