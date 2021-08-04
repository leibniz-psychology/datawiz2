<?php

namespace App\Questionnaire\Forms;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Model\Study\MeasureMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(MetaDataDictionary::MEASURES,  CollectionType::class, [
                'required' => false,
                'entry_type' => TextType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'x-data' => '',
                        'x-on:keydown.enter.prevent' => '',
                    ]
                ],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'Provide definitions of all measures you collected on participants. Provide the proper name of standardized measures (tests).',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-Widget MetaData-Widget_collection',
                    'data-entry-add-label' => 'another measure +',
                    'data-entry-add-class' => 'MetaData-AddButton',
                    'data-entry-remove-class' => 'MetaData-RemoveButton'
                ]
            ])
            ->add(MetaDataDictionary::APPARATUS, CollectionType::class, [
                'required' => false,
                'entry_type' => TextType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'x-data' => '',
                        'x-on:keydown.enter.prevent' => '',
                    ]
                ],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'Which instruments (apparatus, equipment) did you use in your study?',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-Widget MetaData-Widget_collection',
                    'data-entry-add-label' => 'another apparatus +',
                    'data-entry-add-class' => 'MetaData-AddButton',
                    'data-entry-remove-class' => 'MetaData-RemoveButton'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MeasureMetaDataGroup::class,
        ]);
    }
}
