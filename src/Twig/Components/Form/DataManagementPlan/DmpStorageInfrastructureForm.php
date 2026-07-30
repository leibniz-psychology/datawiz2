<?php

declare(strict_types=1);

namespace App\Twig\Components\Form\DataManagementPlan;

use App\Entity\DataManagementPlan\DmpStorageInfrastructure;
use App\Form\DataManagementPlan\DmpStorageInfrastructureType;
use App\Repository\DataManagementPlan\DmpStorageInfrastructureRepository;
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
class DmpStorageInfrastructureForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use DataManagementPlanFormTrait;

    public const string formType = 'storageInfrastructure';

    #[LiveProp]
    public ?DmpStorageInfrastructure $initialFormData = null;

    public function __construct(
        private readonly DmpStorageInfrastructureRepository $storageInfrastructureRepository,
    ) {
    }

    #[LiveAction]
    public function save(#[LiveArg] ?string $route): ?Response
    {
        $this->submitForm();
        /** @var DmpStorageInfrastructure $storageInfrastructure */
        $storageInfrastructure = $this->getForm()->getData();

        $this->storageInfrastructureRepository->save($storageInfrastructure);
        if (!is_null($route)) {
            return $this->redirectToRoute($route, [
                'id' => $storageInfrastructure->getDataManagementPlan()->getId(),
            ]);
        }

        return $this->redirectToRoute('Dmp-edit-storage-infrastructure', ['id' => $storageInfrastructure->getDataManagementPlan()->getId()]);
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(DmpStorageInfrastructureType::class, $this->initialFormData);
    }
}
