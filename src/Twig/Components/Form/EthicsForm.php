<?php

namespace App\Twig\Components\Form;

use App\Entity\Study\EthicsMetaDataGroup;
use App\Form\EthicsType;
use App\Repository\EthicsRepository;
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
class EthicsForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use DatawizFormTrait;
    public const string formType = 'ethics';

    #[LiveProp]
    public ?EthicsMetaDataGroup $initialFormData = null;

    public function __construct(
        private readonly EthicsRepository $ethicsRepository,
    ) {
    }

    #[LiveAction]
    public function save(#[LiveArg] ?string $route): ?Response
    {
        $this->submitForm();
        /** @var EthicsMetaDataGroup $ethics */
        $ethics = $this->getForm()->getData();

        $this->ethicsRepository->save($ethics);
        if (!is_null($route)) {
            return $this->redirectToRoute($route, [
                'id' => $ethics->getExperiment()->getId(),
            ]);
        }

        return $this->redirectToRoute('Study-ethics', ['id' => $ethics->getExperiment()->getId()]);
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(EthicsType::class, $this->initialFormData);
    }
}
