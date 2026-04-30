<?php

namespace App\Form;

use App\Entity\Study\MethodMetaDataGroup;
use App\Enum\ControlOperations;
use App\Enum\ExperimentalDesign;
use App\Enum\ExperimentalDetails;
use App\Enum\MethodDictionary;
use App\Enum\NonExperimentalDetails;
use App\Enum\ObservationalType;
use App\Enum\ResearchMethod;
use App\Enum\StudySetting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MethodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MethodMetaDataGroup::class,
            'translation_domain' => 'forms',
        ]);
    }
}
