<?php

declare(strict_types=1);

namespace App\Twig\Components\Form\Project;

use App\Entity\Project\ProjectAdministrativeData;
use App\Form\Project\ProjectAdministrativeDataType;
use App\Repository\Project\ProjectAdministrativeDataRepository;
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
class ProjectAdministrativeDataForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use ProjectFormTrait;

    public const string formType = 'administrativeData';

    #[LiveProp]
    public ?ProjectAdministrativeData $initialFormData = null;

    public function __construct(
        private readonly ProjectAdministrativeDataRepository $administrativeDataRepository,
    ) {
    }

    #[LiveAction]
    public function save(#[LiveArg] ?string $route): ?Response
    {
        $this->submitForm();
        /** @var ProjectAdministrativeData $administrativeData */
        $administrativeData = $this->getForm()->getData();

        $this->administrativeDataRepository->save($administrativeData);
        if (!is_null($route)) {
            return $this->redirectToRoute($route, [
                'id' => $administrativeData->getProject()?->getId(),
            ]);
        }

        return $this->redirectToRoute('Project-edit-administrative', ['id' => $administrativeData->getProject()?->getId()]);
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(ProjectAdministrativeDataType::class, $this->initialFormData);
    }
}
