<?php

namespace App\Form;

use App\Entity\Study\SampleMetaDataGroup;
use App\Enum\Study\Dictionary\SampleDictionary;
use App\Enum\Study\ParticipantGroup;
use App\Enum\Study\SampleAnalysisUnit;
use App\Enum\Study\SamplingMethod;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SampleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(SampleDictionary::PARTICIPANT_MIN_AGE->value, IntegerType::class, [
                'required' => false,
                'label' => SampleDictionary::PARTICIPANT_MIN_AGE->label(),
            ])
            ->add(SampleDictionary::PARTICIPANT_MAX_AGE->value, IntegerType::class, [
                'required' => false,
                'label' => SampleDictionary::PARTICIPANT_MAX_AGE->label(),
            ])
            ->add(SampleDictionary::PARTICIPANT_MAX_AGE_UNLIMITED->value, CheckboxType::class, [
                'required' => false,
                'label' => SampleDictionary::PARTICIPANT_MAX_AGE_UNLIMITED->label(),
            ])
            ->add(SampleDictionary::PARTICIPANT_GROUPS->value, EnumType::class, [
                'required' => false,
                'placeholder' => false,
                'class' => ParticipantGroup::class,
                'multiple' => true,
                'expanded' => true,
                'label' => SampleDictionary::PARTICIPANT_GROUPS->label(),
                'label_html' => true,
                'choice_label' => fn (ParticipantGroup $group) => $group->labelExtended(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(SampleDictionary::PARTICIPANT_GROUPS_OTHER_DESCRIPTION->value, TextareaType::class, [
                'required' => false,
                'label' => SampleDictionary::PARTICIPANT_GROUPS_OTHER_DESCRIPTION->label(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(SampleDictionary::POPULATION->value, CollectionType::class, [
                'required' => false,
                'entry_type' => TextType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => SampleDictionary::POPULATION->label(),
            ])
            ->add(SampleDictionary::SAMPLING_METHOD->value, EnumType::class, [
                'required' => false,
                'placeholder' => false,
                'class' => SamplingMethod::class,
                'expanded' => true,
                'label' => SampleDictionary::SAMPLING_METHOD->label(),
                'label_html' => true,
                'choice_label' => fn (SamplingMethod $samplingMethod) => $samplingMethod->labelExtended(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(SampleDictionary::SAMPLING_METHOD_OTHER_DESCRIPTION->value, TextareaType::class, [
                'required' => false,
                'label' => SampleDictionary::SAMPLING_METHOD_OTHER_DESCRIPTION->label(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(SampleDictionary::RECRUITING->value, TextareaType::class, [
                'required' => false,
                'label' => SampleDictionary::RECRUITING->label(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(SampleDictionary::SAMPLE_SIZE->value, TextareaType::class, [
                'required' => false,
                'label' => SampleDictionary::SAMPLE_SIZE->label(),
            ])
            ->add(SampleDictionary::POWER_ANALYSIS->value, TextareaType::class, [
                'required' => false,
                'label' => SampleDictionary::POWER_ANALYSIS->label(),
            ])
            ->add(SampleDictionary::INTENDED_SAMPLE_SIZE->value, TextareaType::class, [
                'required' => false,
                'label' => SampleDictionary::INTENDED_SAMPLE_SIZE->label(),
            ])
            ->add(SampleDictionary::UNIT_OF_ANALYSIS->value, EnumType::class, [
                'required' => false,
                'placeholder' => false,
                'class' => SampleAnalysisUnit::class,
                'expanded' => true,
                'label' => SampleDictionary::UNIT_OF_ANALYSIS->label(),
                'choice_label' => fn (SampleAnalysisUnit $unit) => $unit->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(SampleDictionary::UNIT_OF_ANALYSIS_OTHER_DESCRIPTION->value, TextareaType::class, [
                'required' => false,
                'label' => SampleDictionary::UNIT_OF_ANALYSIS_OTHER_DESCRIPTION->label(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(SampleDictionary::MULTILEVEL_STRUCTURE->value, TextareaType::class, [
                'required' => false,
                'label' => SampleDictionary::MULTILEVEL_STRUCTURE->label(),
            ])
            ->add(SampleDictionary::SEX->value, TextType::class, [
                'required' => false,
                'label' => SampleDictionary::SEX->label(),
            ])
            ->add(SampleDictionary::AGE->value, TextType::class, [
                'required' => false,
                'label' => SampleDictionary::AGE->label(),
            ])
            ->add(SampleDictionary::SPECIAL_GROUPS->value, TextType::class, [
                'required' => false,
                'label' => SampleDictionary::SPECIAL_GROUPS->label(),
            ])
            ->add(SampleDictionary::COUNTRY->value, TextType::class, [
                'required' => false,
                'label' => SampleDictionary::COUNTRY->label(),
            ])
            ->add(SampleDictionary::CITY->value, TextType::class, [
                'required' => false,
                'label' => SampleDictionary::CITY->label(),
            ])
            ->add(SampleDictionary::REGION->value, TextType::class, [
                'required' => false,
                'label' => SampleDictionary::REGION->label(),
            ])
            ->add(SampleDictionary::MISSING_VALUES->value, TextareaType::class, [
                'required' => false,
                'label' => SampleDictionary::MISSING_VALUES->label(),
            ])
            ->add(SampleDictionary::RETURN_DROPOUT->value, TextareaType::class, [
                'required' => false,
                'label' => SampleDictionary::RETURN_DROPOUT->label(),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SampleMetaDataGroup::class,
            'translation_domain' => 'forms',
        ]);
    }
}
