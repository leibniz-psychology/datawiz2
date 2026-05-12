<?php

namespace App\Form;

use App\Entity\Study\MeasurementInstrument;
use App\Enum\Study\Dictionary\MeasurementInstrumentDictionary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasurementInstrumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(MeasurementInstrumentDictionary::TITLE->value, TextType::class, [
                'label' => MeasurementInstrumentDictionary::TITLE->label(),
            ])
            ->add(MeasurementInstrumentDictionary::AUTHOR->value, TextType::class, [
                'required' => false,
                'label' => MeasurementInstrumentDictionary::AUTHOR->label(),
                'help' => MeasurementInstrumentDictionary::AUTHOR->help(),
            ])
            ->add(MeasurementInstrumentDictionary::CITATION->value, TextareaType::class, [
                'required' => false,
                'label' => MeasurementInstrumentDictionary::CITATION->label(),
                'help' => MeasurementInstrumentDictionary::CITATION->help(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(MeasurementInstrumentDictionary::NEWLY_DEVELOPED->value, CheckboxType::class, [
                'required' => false,
                'label' => MeasurementInstrumentDictionary::NEWLY_DEVELOPED->label(),
            ])
            ->add(MeasurementInstrumentDictionary::ABSTRACT->value, TextareaType::class, [
                'required' => false,
                'label' => MeasurementInstrumentDictionary::ABSTRACT->label(),
                'help' => MeasurementInstrumentDictionary::ABSTRACT->help(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(MeasurementInstrumentDictionary::THEORETICAL_BACKGROUND->value, TextareaType::class, [
                'required' => false,
                'label' => MeasurementInstrumentDictionary::THEORETICAL_BACKGROUND->label(),
                'help' => MeasurementInstrumentDictionary::THEORETICAL_BACKGROUND->help(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(MeasurementInstrumentDictionary::STRUCTURE->value, TextareaType::class, [
                'required' => false,
                'label' => MeasurementInstrumentDictionary::STRUCTURE->label(),
                'help' => MeasurementInstrumentDictionary::STRUCTURE->help(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(MeasurementInstrumentDictionary::DEVELOPMENT->value, TextareaType::class, [
                'required' => false,
                'label' => MeasurementInstrumentDictionary::DEVELOPMENT->label(),
                'help' => MeasurementInstrumentDictionary::DEVELOPMENT->help(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(MeasurementInstrumentDictionary::OBJECTIVITY->value, TextareaType::class, [
                'required' => false,
                'label' => MeasurementInstrumentDictionary::OBJECTIVITY->label(),
                'help' => MeasurementInstrumentDictionary::OBJECTIVITY->help(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(MeasurementInstrumentDictionary::RELIABILITY->value, TextareaType::class, [
                'required' => false,
                'label' => MeasurementInstrumentDictionary::RELIABILITY->label(),
                'help' => MeasurementInstrumentDictionary::RELIABILITY->help(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(MeasurementInstrumentDictionary::VALIDITY->value, TextareaType::class, [
                'required' => false,
                'label' => MeasurementInstrumentDictionary::VALIDITY->label(),
                'help' => MeasurementInstrumentDictionary::VALIDITY->help(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(MeasurementInstrumentDictionary::NORM_REFERENCED->value, TextareaType::class, [
                'required' => false,
                'label' => MeasurementInstrumentDictionary::NORM_REFERENCED->label(),
                'help' => MeasurementInstrumentDictionary::NORM_REFERENCED->help(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MeasurementInstrument::class,
            'translation_domain' => 'forms',
        ]);
    }
}
