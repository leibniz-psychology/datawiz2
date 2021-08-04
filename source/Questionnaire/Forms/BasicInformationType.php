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
        $Parsedown = new Parsedown();

        $builder
            // ->add(MetaDataDictionary::CREATOR, CollectionType::class, [
            //     'required' => false,
            //     'entry_type' => TextType::class,
            //     'entry_options' => [
            //         'label' => false,
            //         'attr' => [
            //             'x-data' => '',
            //             'x-on:keydown.enter.prevent' => '',
            //         ]
            //     ],
            //     'allow_add' => true,
            //     'prototype' => true,
            //     'allow_delete' => true,
            //     'label' => 'The persons responsible for the research data',
            //     'label_attr' => ['class' => 'MetaData-Label'],
            //     'attr' => [
            //         'class' => 'MetaData-Widget MetaData-Widget_collection',
            //         'data-entry-add-label' => 'another creator +',
            //         'data-entry-add-class' => 'MetaData-AddButton',
            //         'data-entry-remove-class' => 'MetaData-RemoveButton'
            //     ]
            // ])
            // ->add(MetaDataDictionary::CONTACT, CollectionType::class, [
            //     'required' => false,
            //     'entry_type' => TextType::class,
            //     'entry_options' => [
            //         'label' => false,
            //         'attr' => [
            //             'x-data' => '',
            //             'x-on:keydown.enter.prevent' => '',
            //         ]
            //     ],
            //     'allow_add' => true,
            //     'prototype' => true,
            //     'allow_delete' => true,
            //     'label' => 'The contact of the persons responsible',
            //     'label_attr' => ['class' => 'MetaData-Label'],
            //     'attr' => [
            //         'class' => 'MetaData-Widget MetaData-Widget_collection',
            //         'data-entry-add-label' => 'another contact +',
            //         'data-entry-add-class' => 'MetaData-AddButton',
            //         'data-entry-remove-class' => 'MetaData-RemoveButton'
            //     ]
            // ])
            ->add(MetaDataDictionary::TITLE, TextareaType::class, [
                'required' => false,
                'label' => 'Provide a title for your dataset',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                ]
            ])
            ->add(MetaDataDictionary::DESCRIPTION, TextareaType::class, [
                'required' => false,
                'label' => 'Briefly describe the study in which you collected the research data',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                ]
            ])
            ->add(MetaDataDictionary::RELATED_PUBS, CollectionType::class, [
                'required' => false,
                'entry_type' => TextareaType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => $Parsedown->line(
                    '<span class="block">Cite publications that use the data from this dataset.</span><span class="flex items-center mt-3 text-sm"><span class="w-4 h-4 ml-1 mr-1 iconify bg-mono-50" data-icon="mdi:information-variant" data-inline="false"></span>Enter one publication per field. Leave empty if not applicable.</span>'
                ),
                'label_attr' => ['class' => 'MetaData-Label'],
                'label_html' => true,
                'attr' => [
                    'class' => 'MetaData-Widget MetaData-Widget_collection',
                    'data-entry-add-label' => 'another related publication +',
                    'data-entry-add-class' => 'MetaData-AddButton',
                    'data-entry-remove-class' => 'MetaData-RemoveButton'
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
