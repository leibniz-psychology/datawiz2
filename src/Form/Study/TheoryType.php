<?php

namespace App\Form\Study;

use App\Entity\Study\TheoryMetaDataGroup;
use App\Enum\Study\Dictionary\TheoryDictionary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TheoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(TheoryDictionary::OBJECTIVES->value, CollectionType::class, [
                'required' => false,
                'entry_type' => TextareaType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'rows' => '4',
                    ],
                ],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => TheoryDictionary::OBJECTIVES->label(),
            ])
            ->add(TheoryDictionary::HYPOTHESES->value, CollectionType::class, [
                'required' => false,
                'entry_type' => TextareaType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'rows' => '4',
                    ],
                ],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => TheoryDictionary::HYPOTHESES->label(),
            ])
            ->add(TheoryDictionary::EXPLORATORY_RESEARCH_QUESTIONS->value, CollectionType::class, [
                'required' => false,
                'entry_type' => TextareaType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'rows' => '4',
                    ],
                ],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => TheoryDictionary::EXPLORATORY_RESEARCH_QUESTIONS->label(),
            ])
            ->add(TheoryDictionary::THEORIES->value, CollectionType::class, [
                'required' => false,
                'entry_type' => TextareaType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'rows' => '4',
                    ],
                ],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => TheoryDictionary::THEORIES->label(),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TheoryMetaDataGroup::class,
            'translation_domain' => 'forms',
        ]);
    }
}
