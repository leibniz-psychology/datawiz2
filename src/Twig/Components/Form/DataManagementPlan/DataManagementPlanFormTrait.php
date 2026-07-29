<?php

namespace App\Twig\Components\Form\DataManagementPlan;

use App\Repository\Study\ExperimentRepository;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
trait DataManagementPlanFormTrait
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    public const array formOrder = [
        [
            'type' => 'administrativeData',
            'route' => 'Dmp-edit-administrative',
            'title' => 'title.basic.title',
        ],
        [
            'type' => 'researchData',
            'route' => 'Dmp-edit-research-data',
            'title' => 'data_management_plan.research_data.title',
        ],
        [
            'type' => 'documentation',
            'route' => 'Dmp-edit-documentation',
            'title' => 'data_management_plan.documentation.title',
        ],
    ];

    public function __construct(
        private readonly TranslatorInterface $translator,
        private readonly ExperimentRepository $experimentRepository,
    ) {
    }

    /**
     * @return null|array<string, string>
     */
    #[LiveAction]
    public function currentForm(): ?array
    {
        return array_find(self::formOrder, fn ($form) => $form['type'] === static::formType);
    }

    /**
     * @return null|array<string, string>
     */
    #[LiveAction]
    public function nextForm(): ?array
    {
        $returnNextForm = false;
        foreach (self::formOrder as $form) {
            if ($returnNextForm) {
                return $form;
            }
            if ($form['type'] === static::formType) {
                $returnNextForm = true;
            }
        }
        return null;
    }

    /**
     * @return null|array<string, string>
     */
    #[LiveAction]
    public function prevForm(): ?array
    {
        $prevForm = null;
        foreach (self::formOrder as $form) {
            if ($form['type'] === static::formType) {
                return $prevForm;
            }
            $prevForm = $form;
        }
        return null;
    }
}
