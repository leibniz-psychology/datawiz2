<?php

/**
 * This class represent a metadata questionaire within DataWiz
 * means one entire form page within the application.
 */

namespace App\Form\Study;

use App\Entity\Study\EthicsMetaDataGroup;
use App\Enum\Study\Dictionary\EthicsDictionary;
use App\Enum\Study\SharingLevel;
use App\Enum\YesNo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EthicsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(EthicsDictionary::ETHICAL_REVIEW->value, EnumType::class, [
                'required' => false,
                'class' => YesNo::class,
                'label' => EthicsDictionary::ETHICAL_REVIEW->label(),
                'placeholder' => EthicsDictionary::ETHICAL_REVIEW->placeholder(),
                'choice_label' => fn (YesNo $unit) => $unit->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(EthicsDictionary::ETHICAL_REVIEW_DESCRIPTION->value, TextareaType::class, [
                'required' => false,
                'label' => EthicsDictionary::ETHICAL_REVIEW_DESCRIPTION->label(),
                'help' => EthicsDictionary::ETHICAL_REVIEW_DESCRIPTION->help(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(EthicsDictionary::INFORMED_CONSENT->value, EnumType::class, [
                'required' => false,
                'class' => YesNo::class,
                'label' => EthicsDictionary::INFORMED_CONSENT->label(),
                'placeholder' => EthicsDictionary::INFORMED_CONSENT->placeholder(),
                'choice_label' => fn (YesNo $unit) => $unit->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(EthicsDictionary::DATA_SHARING->value, EnumType::class, [
                'required' => false,
                'class' => YesNo::class,
                'label' => EthicsDictionary::DATA_SHARING->label(),
                'placeholder' => EthicsDictionary::DATA_SHARING->placeholder(),
                'help' => EthicsDictionary::DATA_SHARING->help(),
                'choice_label' => fn (YesNo $unit) => $unit->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(EthicsDictionary::DATA_SHARING_LEVEL->value, EnumType::class, [
                'required' => false,
                'class' => SharingLevel::class,
                'label' => EthicsDictionary::DATA_SHARING_LEVEL->label(),
                'help' => EthicsDictionary::DATA_SHARING_LEVEL->help(),
                'placeholder' => false,
                'expanded' => true,
                'choice_label' => fn (SharingLevel $sharingLevel) => $sharingLevel->labelExtended(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(EthicsDictionary::DATA_SHARING_INFRASTRUCTURE->value, TextareaType::class, [
                'required' => false,
                'label' => EthicsDictionary::DATA_SHARING_INFRASTRUCTURE->label(),
                'help' => EthicsDictionary::DATA_SHARING_INFRASTRUCTURE->help(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(EthicsDictionary::PERSONAL_DATA->value, EnumType::class, [
                'required' => false,
                'class' => YesNo::class,
                'label' => EthicsDictionary::PERSONAL_DATA->label(),
                'placeholder' => EthicsDictionary::PERSONAL_DATA->placeholder(),
                'choice_label' => fn (YesNo $unit) => $unit->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(EthicsDictionary::COPYRIGHT->value, EnumType::class, [
                'required' => false,
                'class' => YesNo::class,
                'label' => EthicsDictionary::COPYRIGHT->label(),
                'placeholder' => EthicsDictionary::COPYRIGHT->placeholder(),
                'help' => EthicsDictionary::COPYRIGHT->help(),
                'choice_label' => fn (YesNo $unit) => $unit->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(EthicsDictionary::COPYRIGHT_LICENSES->value, TextareaType::class, [
                'required' => false,
                'label' => EthicsDictionary::COPYRIGHT_LICENSES->label(),
                'help' => EthicsDictionary::COPYRIGHT_LICENSES->help(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(EthicsDictionary::THIRD_PARTY_RIGHTS->value, EnumType::class, [
                'required' => false,
                'class' => YesNo::class,
                'label' => EthicsDictionary::THIRD_PARTY_RIGHTS->label(),
                'placeholder' => EthicsDictionary::THIRD_PARTY_RIGHTS->placeholder(),
                'help' => EthicsDictionary::THIRD_PARTY_RIGHTS->help(),
                'choice_label' => fn (YesNo $unit) => $unit->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(EthicsDictionary::THIRD_PARTY_LICENSES->value, TextareaType::class, [
                'required' => false,
                'label' => EthicsDictionary::THIRD_PARTY_LICENSES->label(),
                'help' => EthicsDictionary::THIRD_PARTY_LICENSES->help(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EthicsMetaDataGroup::class,
            'translation_domain' => 'forms',
        ]);
    }
}
