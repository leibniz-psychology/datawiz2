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
                'label' => 'Creators',
                'label_attr' => ['class' => 'MetaData-Title'],
                'help' => 'The persons responsible for the research data',
                'help_attr' => ['class' => 'px-6 pt-1'],
                'attr' => [
                    'class' => 'px-6 pt-1',
                    'data-entry-add-label' => 'another creator +',
                    'data-entry-add-class' => 'bg-transparent border-0 shadow-none hover:bg-transparent underline mx-auto block mt-1',
                    'data-entry-remove-class' => ''
                ]
            ])
            ->add(MetaDataDictionary::CONTACT, CollectionType::class, [
                'entry_type' => TextType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'Contact',
                'label_attr' => ['class' => 'MetaData-Title'],
                'help' => 'The contact of the persons responsible',
                'help_attr' => ['class' => 'px-6 pt-1'],
                'attr' => [
                    'class' => 'px-6 pt-1',
                    'data-entry-add-label' => 'another contact +',
                    'data-entry-add-class' => 'bg-transparent border-0 shadow-none hover:bg-transparent underline mx-auto block mt-1',
                    'data-entry-remove-class' => ''
                ]
            ])
            ->add(MetaDataDictionary::TITLE, TextareaType::class, [
                'label' => 'Title',
                'label_attr' => ['class' => 'MetaData-Title'],
                'help' => 'The title by which you want your research data to be cited',
                'help_attr' => ['class' => 'px-6 pt-1'],
                'attr' => [
                    'class' => 'p-1',
                ]
            ])
            ->add(MetaDataDictionary::DESCRIPTION, TextareaType::class, [
                'label' => 'Description',
                'label_attr' => ['class' => 'MetaData-Title'],
                'help' => 'A description of your study which the research data belong to',
                'help_attr' => ['class' => 'px-6 pt-1'],
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
                'label' => 'Related publications',
                'help' => 'The bibliographic citation for related publication(s)',
                'label_attr' => ['class' => 'MetaData-Title'],
                'help_attr' => ['class' => 'px-6 pt-1'],
                'attr' => [
                    'class' => 'px-6 pt-1',
                    'data-entry-add-label' => 'another related publication +',
                    'data-entry-add-class' => 'bg-transparent border-0 shadow-none hover:bg-transparent underline mx-auto block mt-1',
                    'data-entry-remove-class' => ''
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
