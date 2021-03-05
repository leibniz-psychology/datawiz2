<?php

namespace App\Questionnaire;

use App\Domain\Definition\MetaDataValuable;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

abstract class MetaDataSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SET_DATA => 'onPreSetData',
        ];
    }

    public function onPreSetData(FormEvent $event): void
    {
        $data = $event->getData();
        $form = $event->getForm();
        $this->preSetData($data, $form);
    }

    abstract protected function preSetData(?MetaDataValuable $entity, FormInterface $form): void;
}
