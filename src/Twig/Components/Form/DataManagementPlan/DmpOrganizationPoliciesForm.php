<?php

declare(strict_types=1);

namespace App\Twig\Components\Form\DataManagementPlan;

use App\Entity\DataManagementPlan\DmpOrganizationPolicies;
use App\Form\DataManagementPlan\DmpOrganizationPoliciesType;
use App\Repository\DataManagementPlan\DmpOrganizationPoliciesRepository;
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
class DmpOrganizationPoliciesForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use DataManagementPlanFormTrait;

    public const string formType = 'organizationPolicies';

    #[LiveProp]
    public ?DmpOrganizationPolicies $initialFormData = null;

    public function __construct(
        private readonly DmpOrganizationPoliciesRepository $organizationPoliciesRepository,
    ) {
    }

    #[LiveAction]
    public function save(#[LiveArg] ?string $route): ?Response
    {
        $this->submitForm();
        /** @var DmpOrganizationPolicies $organizationPolicies */
        $organizationPolicies = $this->getForm()->getData();

        $this->organizationPoliciesRepository->save($organizationPolicies);
        if (!is_null($route)) {
            return $this->redirectToRoute($route, [
                'id' => $organizationPolicies->getDataManagementPlan()->getId(),
            ]);
        }

        return $this->redirectToRoute('Dmp-edit-organization-policies', ['id' => $organizationPolicies->getDataManagementPlan()->getId()]);
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(DmpOrganizationPoliciesType::class, $this->initialFormData);
    }
}
