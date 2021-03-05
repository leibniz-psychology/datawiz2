<?php
/**
 * This class implements the EventSubscriber Interface to enable better reuse
 * in different forms within DataWiz.
 */

namespace App\Questionnaire\Fields;

use App\Domain\Definition\MetaDataValuable;
use App\Questionnaire\MetaDataSubscriber;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;

class ShortNameSubscriber extends MetaDataSubscriber
{
    protected function preSetData(?MetaDataValuable $entity, FormInterface $form): void
    {
        $form->add('shortName', TextType::class);
    }
}
