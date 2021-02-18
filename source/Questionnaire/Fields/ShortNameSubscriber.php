<?php
/**
 * This class implements the EventSubscriber Interface to enable better reuse
 * in different forms within DataWiz.
 */

namespace App\Questionnaire\Fields;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ShortNameSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SET_DATA => 'onPreSetData',
        ];
    }

    public function onPreSetData(FormEvent $event): void
    {
        $event->getForm()->add('shortName', TextType::class);
    }
}
