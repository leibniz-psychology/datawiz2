<?php

namespace App\Questionnaire\Forms;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Model\Study\BasicInformationMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Parsedown;

class BasicInformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $parseDown = new Parsedown();

        $builder
            ->add(MetaDataDictionary::TITLE, TextareaType::class, [
                'required' => false,
                'label' => 'input.title.label',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                    'rows' => '3'
                ]
            ])
            ->add(MetaDataDictionary::DESCRIPTION, TextareaType::class, [
                'required' => false,
                'label' => 'input.description.label',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                    'rows' => '14'
                ]
            ])
            ->add(MetaDataDictionary::RELATED_PUBS, CollectionType::class, [
                'required' => false,
                'entry_type' => TextareaType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'class' => 'w-full',
                        'rows' => '4'
                    ]
                ],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => $parseDown->line(
                    'input.relatedPubs.label'
                ),
                'label_attr' => ['class' => 'MetaData-Label'],
                'label_html' => true,
                'attr' => [
                    'class' => 'MetaData-Widget MetaData-Widget_collection',
                ]
            ])
            ->add(MetaDataDictionary::CREATORS, CollectionType::class, [
                'entry_type' => CreatorType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'x-data' => '',
                        'x-on:keydown.enter.prevent' => '',
                        'class' => 'Creator-Details'
                    ]
                ],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'input.creator.label',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-Widget MetaData-Widget_collection',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BasicInformationMetaDataGroup::class,
        ]);
    }
}
