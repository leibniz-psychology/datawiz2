<?php

/**
 * This class represent a metadata questionaire within DataWiz
 * means one entire form page within the application.
 */

namespace App\Form;

use App\Entity\Study\EthicsMetaDataGroup;
use App\Enum\Study\Dictionary\EthicsDictionary;
use App\Enum\YesNo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EthicsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(EthicsDictionary::ETHICAL_REVIEW->value, EnumType::class, [
                'required' => false,
                'placeholder' => EthicsDictionary::ETHICAL_REVIEW->placeholder(),
                'class' => YesNo::class,
                'label' => EthicsDictionary::ETHICAL_REVIEW->label(),
                'choice_label' => fn (YesNo $unit) => $unit->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(EthicsDictionary::INFORMED_CONSENT->value, EnumType::class, [
                'required' => false,
                'placeholder' => EthicsDictionary::INFORMED_CONSENT->placeholder(),
                'class' => YesNo::class,
                'label' => EthicsDictionary::INFORMED_CONSENT->label(),
                'choice_label' => fn (YesNo $unit) => $unit->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(EthicsDictionary::PERSONAL_DATA->value, EnumType::class, [
                'required' => false,
                'placeholder' => EthicsDictionary::PERSONAL_DATA->placeholder(),
                'class' => YesNo::class,
                'label' => EthicsDictionary::PERSONAL_DATA->label(),
                'choice_label' => fn (YesNo $unit) => $unit->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(EthicsDictionary::COPYRIGHT->value, EnumType::class, [
                'required' => false,
                'placeholder' => EthicsDictionary::COPYRIGHT->placeholder(),
                'class' => YesNo::class,
                'label' => EthicsDictionary::COPYRIGHT->label(),
                'choice_label' => fn (YesNo $unit) => $unit->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(EthicsDictionary::THIRD_PARTY_RIGHTS->value, EnumType::class, [
                'required' => false,
                'placeholder' => EthicsDictionary::THIRD_PARTY_RIGHTS->placeholder(),
                'class' => YesNo::class,
                'label' => EthicsDictionary::THIRD_PARTY_RIGHTS->label(),
                'choice_label' => fn (YesNo $unit) => $unit->label(),
                'choice_translation_domain' => 'enums',
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
