<?php

declare(strict_types=1);

namespace App\Twig\Components\Form\Project;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
trait ProjectFormTrait
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    public const array formOrder = [
        [
            'type' => 'administrativeData',
            'route' => 'Project-edit-administrative',
            'title' => 'project.administrative_data.title',
        ],
        [
            'type' => 'studies',
            'route' => 'Project-studies',
            'title' => 'project.studies.title',
        ],
        [
            'type' => 'materials',
            'route' => 'Project-materials',
            'title' => 'project.materials.title-short',
        ],
    ];

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
