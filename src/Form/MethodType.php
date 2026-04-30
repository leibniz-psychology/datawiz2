<?php

namespace App\Form;

use App\Entity\Study\MethodMetaDataGroup;
use App\Enum\Study\ControlOperations;
use App\Enum\Study\Dictionary\MethodDictionary;
use App\Enum\Study\ExperimentalDesign;
use App\Enum\Study\ExperimentalDetails;
use App\Enum\Study\NonExperimentalDetails;
use App\Enum\Study\ObservationalType;
use App\Enum\Study\ResearchDesign;
use App\Enum\Study\ResearchMethod;
use App\Enum\Study\StudySetting;
use App\Enum\Study\SurveyInstrumentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MethodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(MethodDictionary::RESEARCH_DESIGN->value, EnumType::class, [
                'required' => false,
                'placeholder' => false,
                'class' => ResearchDesign::class,
                'expanded' => true,
                'label' => MethodDictionary::RESEARCH_DESIGN->label(),
                'label_html' => true,
                'choice_label' => fn (ResearchDesign $researchDesign) => $researchDesign->labelExtended(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(MethodDictionary::RESEARCH_DESIGN_DESCRIPTION->value, TextareaType::class, [
                'required' => false,
                'label' => MethodDictionary::RESEARCH_DESIGN_DESCRIPTION->label(),
                'help' => MethodDictionary::RESEARCH_DESIGN_DESCRIPTION->help(),
                'attr' => ['rows' => '4'],
            ])
            ->add(MethodDictionary::SETTING->value, EnumType::class, [
                'required' => false,
                'placeholder' => false,
                'class' => StudySetting::class,
                'expanded' => true,
                'label' => MethodDictionary::SETTING->label(),
                'choice_label' => fn (StudySetting $setting) => $setting->labelExtended(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(MethodDictionary::SETTING_LOCATION->value, TextareaType::class, [
                'required' => false,
                'label' => MethodDictionary::SETTING_LOCATION->label(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(MethodDictionary::RESEARCH_METHOD->value, EnumType::class, [
                'required' => false,
                'placeholder' => false,
                'class' => ResearchMethod::class,
                'expanded' => true,
                'label' => MethodDictionary::RESEARCH_METHOD->label(),
                'label_html' => true,
                'choice_label' => fn (ResearchMethod $method) => $method->labelExtended(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(MethodDictionary::EXPERIMENTAL_DETAILS->value, EnumType::class, [
                'required' => false,
                'placeholder' => false,
                'class' => ExperimentalDetails::class,
                'expanded' => true,
                'label' => MethodDictionary::EXPERIMENTAL_DETAILS->label(),
                'label_html' => true,
                'choice_label' => fn (ExperimentalDetails $details) => $details->labelExtended(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(MethodDictionary::NON_EXPERIMENTAL_DETAILS->value, EnumType::class, [
                'required' => false,
                'placeholder' => false,
                'class' => NonExperimentalDetails::class,
                'expanded' => true,
                'label' => MethodDictionary::NON_EXPERIMENTAL_DETAILS->label(),
                'label_html' => true,
                'choice_label' => fn (NonExperimentalDetails $details) => $details->labelExtended(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(MethodDictionary::OBSERVATIONAL_TYPE->value, EnumType::class, [
                'required' => false,
                'placeholder' => MethodDictionary::OBSERVATIONAL_TYPE->placeholder(),
                'class' => ObservationalType::class,
                'label' => MethodDictionary::OBSERVATIONAL_TYPE->label(),
                'choice_label' => fn (ObservationalType $details) => $details->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(MethodDictionary::MANIPULATIONS->value, TextareaType::class, [
                'required' => false,
                'label' => MethodDictionary::MANIPULATIONS->label(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(MethodDictionary::EXPERIMENTAL_DESIGN->value, EnumType::class, [
                'required' => false,
                'placeholder' => false,
                'class' => ExperimentalDesign::class,
                'expanded' => true,
                'label' => MethodDictionary::EXPERIMENTAL_DESIGN->label(),
                'choice_label' => fn (ExperimentalDesign $design) => $design->labelExtended(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(MethodDictionary::CONTROL_OPERATIONS->value, EnumType::class, [
                'required' => false,
                'placeholder' => false,
                'class' => ControlOperations::class,
                'expanded' => true,
                'label' => MethodDictionary::CONTROL_OPERATIONS->label(),
                'choice_label' => fn (ControlOperations $controlOperations) => $controlOperations->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(MethodDictionary::OTHER_CONTROL_OPERATIONS->value, TextareaType::class, [
                'required' => false,
                'label' => MethodDictionary::OTHER_CONTROL_OPERATIONS->label(),
                'attr' => ['rows' => '4'],
            ])
            ->add(MethodDictionary::SURVEY_INSTRUMENT_TYPE->value, EnumType::class, [
                'required' => false,
                'placeholder' => MethodDictionary::SURVEY_INSTRUMENT_TYPE->placeholder(),
                'class' => SurveyInstrumentType::class,
                'label' => MethodDictionary::SURVEY_INSTRUMENT_TYPE->label(),
                'choice_label' => fn (SurveyInstrumentType $instrumentType) => $instrumentType->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(MethodDictionary::TREATMENT_GROUPS->value, CollectionType::class, [
                'required' => false,
                'entry_type' => TextType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => MethodDictionary::TREATMENT_GROUPS->label(),
            ])
            ->add(MethodDictionary::RESEARCH_METHOD_DESCRIPTION->value, TextareaType::class, [
                'required' => false,
                'label' => MethodDictionary::RESEARCH_METHOD_DESCRIPTION->label(),
                'attr' => ['rows' => '4'],
            ])
            ->add(MethodDictionary::MEASUREMENT_OCCASIONS->value, CollectionType::class, [
                'entry_type' => MeasurementOccasionType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => MethodDictionary::MEASUREMENT_OCCASIONS->label(),
            ])
            ->add(MethodDictionary::CONSTRUCTS->value, CollectionType::class, [
                'entry_type' => MethodConstructType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => MethodDictionary::CONSTRUCTS->label(),
            ])
            ->add(MethodDictionary::MEASUREMENT_INSTRUMENTS->value, CollectionType::class, [
                'entry_type' => MeasurementInstrumentType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => MethodDictionary::MEASUREMENT_INSTRUMENTS->label(),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MethodMetaDataGroup::class,
            'translation_domain' => 'forms',
        ]);
    }
}
