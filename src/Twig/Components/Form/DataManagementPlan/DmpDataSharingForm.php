<?php

declare(strict_types=1);

namespace App\Twig\Components\Form\DataManagementPlan;

use App\Entity\DataManagementPlan\DmpDataSharing;
use App\Form\DataManagementPlan\DmpDataSharingType;
use App\Repository\DataManagementPlan\DmpDataSharingRepository;
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
class DmpDataSharingForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use DataManagementPlanFormTrait;

    public const string formType = 'dataSharing';

    #[LiveProp]
    public ?DmpDataSharing $initialFormData = null;

    public function __construct(
        private readonly DmpDataSharingRepository $dataSharingRepository,
    ) {
    }

    #[LiveAction]
    public function save(#[LiveArg] ?string $route): ?Response
    {
        $this->submitForm();
        /** @var DmpDataSharing $dataSharing */
        $dataSharing = $this->getForm()->getData();

        $this->dataSharingRepository->save($dataSharing);
        if (!is_null($route)) {
            return $this->redirectToRoute($route, [
                'id' => $dataSharing->getDataManagementPlan()->getId(),
            ]);
        }

        return $this->redirectToRoute('Dmp-edit-data-sharing', ['id' => $dataSharing->getDataManagementPlan()->getId()]);
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(DmpDataSharingType::class, $this->initialFormData);
    }
}
