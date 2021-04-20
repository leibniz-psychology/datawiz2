<?php

namespace App\Questionnaire\Forms;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Model\Study\BasicInformationMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BasicInformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(MetaDataDictionary::CREATOR, CollectionType::class, [
                'entry_type' => TextType::class,
                'entry_options' => ['label'=>false],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
            ])
            ->add(MetaDataDictionary::CONTACT, CollectionType::class, [
                'entry_type' => TextType::class,
                'entry_options' => ['label'=>false],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
            ])
            ->add(MetaDataDictionary::TITLE, TextareaType::class)
            ->add(MetaDataDictionary::DESCRIPTION, TextareaType::class)
            ->add(MetaDataDictionary::RELATED_PUBS, CollectionType::class, [
                'entry_type' => TextareaType::class,
                'entry_options' => ['label'=>false],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BasicInformationMetaDataGroup::class,
        ]);
    }
}
