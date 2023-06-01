<?php

namespace App\Questionnaire\Forms;

use App\Domain\Definition\MetaDataDictionary;
use App\Entity\Study\MeasureMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(MetaDataDictionary::MEASURES, CollectionType::class, [
                'required' => false,
                'entry_type' => TextareaType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'class' => 'w-full',
                        'rows' => '3',
                    ],
                ],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'input.measures.label',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => ['class' => 'MetaData-Widget MetaData-Widget_collection'],
            ])
            ->add(MetaDataDictionary::APPARATUS, CollectionType::class, [
                'required' => false,
                'entry_type' => TextareaType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'class' => 'w-full',
                        'rows' => '3',
                    ],
                ],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'input.apparatus.label',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => ['class' => 'MetaData-Widget MetaData-Widget_collection'],
            ])
            ->add('saveAndPrevious', SubmitType::class)
            ->add('saveAndNext', SubmitType::class)
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
        $resolver->setDefaults(['data_class' => MeasureMetaDataGroup::class]);
    }
}
