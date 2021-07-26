<?php

namespace App\Questionnaire\Forms;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Model\Study\SampleMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SampleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("participants", TextareaType::class, [
                'required' => false,
                'label' => 'Describe participants, specifying their pertinent characteristics for this study',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                ]
            ])
            ->add(MetaDataDictionary::INCLUSION_CRITERIA, CollectionType::class, [
                'required' => false,
                'entry_type' => TextType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'State inclusion criteria for participants',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-Widget MetaData-Widget_collection',
                    'data-entry-add-label' => 'another creator +',
                    'data-entry-add-class' => 'MetaData-AddButton',
                    'data-entry-remove-class' => 'MetaData-RemoveButton'
                ]
            ])
            ->add(MetaDataDictionary::EXCLUSION_CRITERIA, CollectionType::class, [
                'required' => false,
                'entry_type' => TextType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'State exclusion criteria for participants',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-Widget MetaData-Widget_collection',
                    'data-entry-add-label' => 'another creator +',
                    'data-entry-add-class' => 'MetaData-AddButton',
                    'data-entry-remove-class' => 'MetaData-RemoveButton'
                ]
            ])
            ->add(MetaDataDictionary::POPULATION, CollectionType::class, [
                'required' => false,
                'entry_type' => TextType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'Provide information on the group of individuals to which your results can be generalized',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-Widget MetaData-Widget_collection',
                    'data-entry-add-label' => 'another creator +',
                    'data-entry-add-class' => 'MetaData-AddButton',
                    'data-entry-remove-class' => 'MetaData-RemoveButton'
                ]
            ])
            ->add(MetaDataDictionary::SAMPLING_METHOD, TextareaType::class, [
                'required' => false,
                'label' => '',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                ]
            ])
            ->add(MetaDataDictionary::SAMPLE_SIZE, TextType::class, [
                'required' => false,
                'label' => 'Provide the achieved sample size as total number of cases N or as number of cases in subsamples n',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                ]
            ])
            ->add(MetaDataDictionary::POWER_ANALYSIS, TextareaType::class, [
                'required' => false,
                'label' => 'Provide details of the power analysis used to calculate your sample size ',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SampleMetaDataGroup::class,
        ]);
    }
}
