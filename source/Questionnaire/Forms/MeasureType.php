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
                'entry_options' => ['label'=>false],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'Tests and measures',
                'help' => 'Provide definitions of all measures you collected on participants. Provide the proper name of standardized measures (tests).',
            ])
            ->add(MetaDataDictionary::APPARATUS, TextareaType::class, [
                'label' => 'Apparatus (Instruments, Equipment)',
                'help' => 'Which instruments (apparatus, equipment) did you use in your study?',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MeasureMetaDataGroup::class,
        ]);
    }
}
