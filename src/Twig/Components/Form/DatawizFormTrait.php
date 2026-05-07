<?php

namespace App\Twig\Components\Form;

use App\Repository\ExperimentRepository;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
trait DatawizFormTrait
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    public const array formOrder = [
        [
            'type' => 'documentation',
            'route' => 'Study-documentation',
            'title' => 'title.basic.title',
        ],
        [
            'type' => 'theory',
            'route' => 'Study-theory',
            'title' => 'title.theories.title',
        ],
        [
            'type' => 'method',
            'route' => 'Study-method',
            'title' => 'title.method.title',
        ],
        [
            'type' => 'measure',
            'route' => 'Study-measure',
            'title' => 'title.measures.title',
        ],
        [
            'type' => 'sample',
            'route' => 'Study-sample',
            'title' => 'title.samples.title',
        ],
        [
            'type' => 'ethics',
            'route' => 'Study-ethics',
            'title' => 'title.ethics.title',
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
