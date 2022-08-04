<?php

namespace App\Questionnaire\Forms;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Model\Study\BasicInformationMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BasicInformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(MetaDataDictionary::TITLE, TextareaType::class, [
                'required' => false,
                'label' => 'input.title.label',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                    'rows' => '3',
                ],
            ])
            ->add(MetaDataDictionary::DESCRIPTION, TextareaType::class, [
                'required' => false,
                'label' => 'input.description.label',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                    'rows' => '14',
                ],
            ])
            ->add(MetaDataDictionary::RELATED_PUBS, CollectionType::class, [
                'required' => false,
                'entry_type' => TextareaType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'class' => 'w-full',
                        'rows' => '4',
                    ],
                ],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'input.relatedPubs.label',
                'label_attr' => ['class' => 'MetaData-Label'],
                'label_html' => true,
                'attr' => [
                    'class' => 'MetaData-Widget MetaData-Widget_collection',
                ],
            ])
            ->add(MetaDataDictionary::CREATORS, CollectionType::class, [
                'entry_type' => CreatorType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'x-data' => '',
                        'x-on:keydown.enter.prevent' => '',
                        'class' => 'Creator-Details',
                    ],
                ],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'input.creator.label',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-Widget MetaData-Widget_collection',
                ],
            ])
            ->add('saveAndNext', SubmitType::class, [
                'label' => 'title.theroies.title',
            ])
            ->add('saveAndIntroduction', SubmitType::class, [
                'label' => 'input.hidden',
                'attr' => [
                    'class' => 'hidden Button_saveAndIntroduction',
                ],
            ])
            ->add('saveAndDocumentation', SubmitType::class, [
                'label' => 'input.hidden',
                'attr' => [
                    'class' => 'hidden Button_saveAndDocumentation',
                ],
            ])
            ->add('saveAndTheory', SubmitType::class, [
                'label' => 'input.hidden',
                'attr' => [
                    'class' => 'hidden Button_saveAndTheory',
                ],
            ])
            ->add('saveAndMethod', SubmitType::class, [
                'label' => 'input.hidden',
                'attr' => [
                    'class' => 'hidden Button_saveAndMethod',
                ],
            ])
            ->add('saveAndMeasure', SubmitType::class, [
                'label' => 'input.hidden',
                'attr' => [
                    'class' => 'hidden Button_saveAndMeasure',
                ],
            ])
            ->add('saveAndSample', SubmitType::class, [
                'label' => 'input.hidden',
                'attr' => [
                    'class' => 'hidden Button_saveAndSample',
                ],
            ])
            ->add('saveAndDatasets', SubmitType::class, [
                'label' => 'input.hidden',
                'attr' => [
                    'class' => 'hidden Button_saveAndDatasets',
                ],
            ])
            ->add('saveAndMaterials', SubmitType::class, [
                'label' => 'input.hidden',
                'attr' => [
                    'class' => 'hidden Button_saveAndMaterials',
                ],
            ])
            ->add('saveAndReview', SubmitType::class, [
                'label' => 'input.hidden',
                'attr' => [
                    'class' => 'hidden Button_saveAndReview',
                ],
            ])
            ->add('saveAndExport', SubmitType::class, [
                'label' => 'input.hidden',
                'attr' => [
                    'class' => 'hidden Button_saveAndExport',
                ],
            ])
            ->add('saveAndSettings', SubmitType::class, [
                'label' => 'input.hidden',
                'attr' => [
                    'class' => 'hidden Button_saveAndSettings',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => BasicInformationMetaDataGroup::class,
            ]
        );
    }
}
