<?php

namespace App\Form;

use App\Entity\Study\CreatorMetaDataGroup;
use App\Enum\CreatorCreditRole;
use App\Enum\CreatorDictionary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreatorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(CreatorDictionary::GIVEN_NAME->value, TextType::class, [
                'required' => false,
                'label' => CreatorDictionary::GIVEN_NAME->label(),
            ])
            ->add(CreatorDictionary::FAMILY_NAME->value, TextType::class, [
                'required' => false,
                'label' => CreatorDictionary::FAMILY_NAME->label(),
            ])
            ->add(CreatorDictionary::EMAIL->value, EmailType::class, [
                'required' => false,
                'label' => CreatorDictionary::EMAIL->label(),
            ])
            ->add(CreatorDictionary::ORCID->value, TextType::class, [
                'required' => false,
                'label' => CreatorDictionary::ORCID->label(),
            ])
            ->add(CreatorDictionary::AFFILIATION->value, TextType::class, [
                'required' => false,
                'label' => CreatorDictionary::AFFILIATION->label(),
            ])
            ->add(CreatorDictionary::CREDIT_ROLES->value, CollectionType::class, [
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => CreatorDictionary::CREDIT_ROLES->label(),
                'required' => false,
                'entry_type' => EnumType::class,
                'delete_empty' => fn (?CreatorCreditRole $role = null) => empty($role),
                'entry_options' => [
                    'class' => CreatorCreditRole::class,
                    'placeholder' => 'creator_credit_role.placeholder',
                    'required' => true,
                    'choice_label' => fn (CreatorCreditRole $role) => $role->label(),
                    'translation_domain' => 'enums',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreatorMetaDataGroup::class,
            'translation_domain' => 'forms',
        ]);
    }
}
