<?php

namespace App\Form\Study;

use App\Entity\Study\MeasurementOccasion;
use App\Enum\Study\Dictionary\MeasurementOccasionDictionary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasurementOccasionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(MeasurementOccasionDictionary::TIME_OF_MEASUREMENT->value, TextType::class, [
                'required' => false,
                'label' => MeasurementOccasionDictionary::TIME_OF_MEASUREMENT->label(),
            ])
            ->add(MeasurementOccasionDictionary::INTERVENTION->value, CheckboxType::class, [
                'required' => false,
                'label' => MeasurementOccasionDictionary::INTERVENTION->label(),
            ])
            ->add(MeasurementOccasionDictionary::POSITION->value, NumberType::class, [
                'attr' => [
                    'class' => 'hidden',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MeasurementOccasion::class,
            'translation_domain' => 'forms',
        ]);
    }
}
