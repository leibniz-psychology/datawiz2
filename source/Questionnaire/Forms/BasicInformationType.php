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
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'The persons responsible for the research data',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-Widget',
                    'data-entry-add-label' => 'another creator +',
                    'data-entry-add-class' => 'MetaData-AddButton',
                    'data-entry-remove-class' => 'MetaData-RemoveButton'
                ]
            ])
            ->add(MetaDataDictionary::CONTACT, CollectionType::class, [
                'entry_type' => TextType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'The contact of the persons responsible',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-Widget',
                    'data-entry-add-label' => 'another contact +',
                    'data-entry-add-class' => 'MetaData-AddButton',
                    'data-entry-remove-class' => 'MetaData-RemoveButton'
                ]
            ])
            ->add(MetaDataDictionary::TITLE, TextareaType::class, [
                'label' => 'The title by which you want your research data to be cited',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'p-1',
                ]
            ])
            ->add(MetaDataDictionary::DESCRIPTION, TextareaType::class, [
                'label' => 'A description of your study which the research data belong to',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'p-1',
                ]
            ])
            ->add(MetaDataDictionary::RELATED_PUBS, CollectionType::class, [
                'entry_type' => TextareaType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'The bibliographic citation for related publication(s)',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-Widget',
                    'data-entry-add-label' => 'another related publication +',
                    'data-entry-add-class' => 'MetaData-AddButton',
                    'data-entry-remove-class' => 'MetaData-RemoveButton'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BasicInformationMetaDataGroup::class,
        ]);
    }
}
