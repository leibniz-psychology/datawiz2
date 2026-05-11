<?php

namespace App\Form;

use App\Entity\Study\CreatorMetaDataGroup;
use App\Enum\Study\CreatorResponsibility;
use App\Enum\Study\Dictionary\CreatorDictionary;
use Symfony\Component\Form\AbstractType;
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
            ->add(CreatorDictionary::RESPONSIBILITIES->value, EnumType::class, [
                'required' => false,
                'placeholder' => false,
                'class' => CreatorResponsibility::class,
                'expanded' => true,
                'multiple' => true,
                'label' => CreatorDictionary::RESPONSIBILITIES->label(),
                'choice_label' => fn (CreatorResponsibility $details) => $details->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(CreatorDictionary::RESPONSIBILITIES_OTHER_DESCRIPTION->value, TextType::class, [
                'required' => false,
                'label' => CreatorDictionary::RESPONSIBILITIES_OTHER_DESCRIPTION->label(),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreatorMetaDataGroup::class,
            'translation_domain' => 'forms',
        ]);
    }
}
