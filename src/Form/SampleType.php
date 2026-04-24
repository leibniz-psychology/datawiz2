<?php

namespace App\Form;

use App\Entity\Constant\MetaDataDictionary;
use App\Entity\Study\SampleMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('participants', TextareaType::class, [
                'required' => false,
                'label' => 'input.participants.label',
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(MetaDataDictionary::POPULATION, CollectionType::class, [
                'required' => false,
                'entry_type' => TextType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'input.population.label',
            ])
            ->add(MetaDataDictionary::INCLUSION_CRITERIA, CollectionType::class, [
                'required' => false,
                'entry_type' => TextType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'input.inclusion.label',
            ])
            ->add(MetaDataDictionary::EXCLUSION_CRITERIA, CollectionType::class, [
                'required' => false,
                'entry_type' => TextType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'input.exclusion.label',
            ])
            ->add(MetaDataDictionary::SAMPLING_METHOD, ChoiceType::class, [
                'required' => false,
                'expanded' => true,
                'placeholder' => false,
                'label' => 'input.sampling.label',
                'choices' => [
                    'input.sampling.choices.convenience' => 'Convenience sampling (accidental sampling, opportunity sampling)',
                    'input.sampling.choices.random' => 'Random sampling (probability sampling)',
                    'input.sampling.choices.systematic' => 'Systematic sampling (quasirandom sampling)',
                    'input.sampling.choices.stratified' => 'Stratified sampling',
                    'input.sampling.choices.quota' => 'Quota sampling',
                    'input.sampling.choices.other' => 'Other',
                ],
                'label_html' => true,
            ])
            ->add('otherSamplingMethod', TextareaType::class, [
                'required' => false,
                'label' => 'input.sampling.other.label',
            ])
            ->add(MetaDataDictionary::SAMPLE_SIZE, TextareaType::class, [
                'required' => false,
                'label' => 'input.sample-size.label',
            ])
            ->add(MetaDataDictionary::POWER_ANALYSIS, TextareaType::class, [
                'required' => false,
                'label' => 'input.power-analysis.label',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => SampleMetaDataGroup::class]);
    }
}
