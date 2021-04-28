<?php

namespace App\Questionnaire\Forms;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Model\Study\MeasureMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(MetaDataDictionary::MEASURES,  CollectionType::class, [
                'entry_type' => TextType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'Tests and measures',
                'label_attr' => ['class' => 'MetaData-Title'],
                'help' => 'Provide definitions of all measures you collected on participants. Provide the proper name of standardized measures (tests).',
                'help_attr' => ['class' => 'px-6 pt-1'],
                'attr' => [
                    'class' => 'px-6 pt-1',
                    'data-entry-add-label' => 'another measure +',
                    'data-entry-add-class' => 'bg-transparent border-0 shadow-none hover:bg-transparent underline mx-auto block mt-1',
                    'data-entry-remove-class' => ''
                ]
            ])
            ->add(MetaDataDictionary::APPARATUS, CollectionType::class, [
                'entry_type' => TextType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'Apparatus (Instruments, Equipment)',
                'help' => 'Which instruments (apparatus, equipment) did you use in your study?',
                'label_attr' => ['class' => 'MetaData-Title'],
                'help_attr' => ['class' => 'px-6 pt-1'],
                'attr' => [
                    'class' => 'px-6 pt-1',
                    'data-entry-add-label' => 'another apparatus +',
                    'data-entry-add-class' => 'bg-transparent border-0 shadow-none hover:bg-transparent underline mx-auto block mt-1',
                    'data-entry-remove-class' => ''
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MeasureMetaDataGroup::class,
        ]);
    }
}
