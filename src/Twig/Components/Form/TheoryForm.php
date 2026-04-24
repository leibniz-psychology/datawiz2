<?php

namespace App\Twig\Components\Form;

use App\Entity\Study\TheoryMetaDataGroup;
use App\Form\TheoryType;
use App\Repository\TheoryRepository;
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
class TheoryForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use DatawizFormTrait;
    public const string formType = 'theory';

    #[LiveProp]
    public ?TheoryMetaDataGroup $initialFormData = null;

    public function __construct(
        private readonly TheoryRepository $theoryRepository,
    ) {
    }

    #[LiveAction]
    public function save(#[LiveArg] ?string $route): ?Response
    {
        $this->submitForm();
        /** @var TheoryMetaDataGroup $theory */
        $theory = $this->getForm()->getData();

        $this->theoryRepository->save($theory);
        if (!is_null($route)) {
            return $this->redirectToRoute($route, [
                'id' => $theory->getExperiment()->getId(),
            ]);
        }

        return $this->redirectToRoute('Study-theory', ['id' => $theory->getExperiment()->getId()]);
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(TheoryType::class, $this->initialFormData);
    }
}
