<?php

declare(strict_types=1);

namespace App\Form\DataManagementPlan;

use App\Entity\DataManagementPlan\DmpEthicalLegal;
use App\Enum\DataManagementPlan\Dictionary\DmpEthicalLegalDictionary;
use App\Enum\YesNo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DmpEthicalLegalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(DmpEthicalLegalDictionary::ETHICAL_REVIEW->value, TextareaType::class, [
                'required' => false,
                'label' => DmpEthicalLegalDictionary::ETHICAL_REVIEW->label(),
                'help' => DmpEthicalLegalDictionary::ETHICAL_REVIEW->help(),
                'attr' => ['rows' => '5'],
            ])
            ->add(DmpEthicalLegalDictionary::INFORMED_CONSENT->value, EnumType::class, [
                'required' => false,
                'label' => DmpEthicalLegalDictionary::INFORMED_CONSENT->label(),
                'help' => DmpEthicalLegalDictionary::INFORMED_CONSENT->help(),
                'class' => YesNo::class,
                'placeholder' => DmpEthicalLegalDictionary::INFORMED_CONSENT->placeholder(),
                'choice_label' => fn (YesNo $yesNo) => $yesNo->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpEthicalLegalDictionary::INFORMED_CONSENT_DATA_SHARING->value, EnumType::class, [
                'required' => false,
                'label' => DmpEthicalLegalDictionary::INFORMED_CONSENT_DATA_SHARING->label(),
                'help' => DmpEthicalLegalDictionary::INFORMED_CONSENT_DATA_SHARING->help(),
                'class' => YesNo::class,
                'placeholder' => DmpEthicalLegalDictionary::INFORMED_CONSENT_DATA_SHARING->placeholder(),
                'choice_label' => fn (YesNo $yesNo) => $yesNo->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpEthicalLegalDictionary::NO_INFORMED_CONSENT_REASON->value, TextareaType::class, [
                'required' => false,
                'label' => DmpEthicalLegalDictionary::NO_INFORMED_CONSENT_REASON->label(),
                'help' => DmpEthicalLegalDictionary::NO_INFORMED_CONSENT_REASON->help(),
                'attr' => ['rows' => '5'],
            ])
            ->add(DmpEthicalLegalDictionary::PERSONAL_DATA->value, EnumType::class, [
                'required' => false,
                'label' => DmpEthicalLegalDictionary::PERSONAL_DATA->label(),
                'help' => DmpEthicalLegalDictionary::PERSONAL_DATA->help(),
                'class' => YesNo::class,
                'placeholder' => DmpEthicalLegalDictionary::PERSONAL_DATA->placeholder(),
                'choice_label' => fn (YesNo $yesNo) => $yesNo->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpEthicalLegalDictionary::PERSONAL_DATA_PROTECTION_MEASURES->value, TextareaType::class, [
                'required' => false,
                'label' => DmpEthicalLegalDictionary::PERSONAL_DATA_PROTECTION_MEASURES->label(),
                'help' => DmpEthicalLegalDictionary::PERSONAL_DATA_PROTECTION_MEASURES->help(),
                'attr' => ['rows' => '5'],
            ])
            ->add(DmpEthicalLegalDictionary::COMMERCIAL_SENSITIVE_DATA->value, EnumType::class, [
                'required' => false,
                'label' => DmpEthicalLegalDictionary::COMMERCIAL_SENSITIVE_DATA->label(),
                'help' => DmpEthicalLegalDictionary::COMMERCIAL_SENSITIVE_DATA->help(),
                'class' => YesNo::class,
                'placeholder' => DmpEthicalLegalDictionary::COMMERCIAL_SENSITIVE_DATA->placeholder(),
                'choice_label' => fn (YesNo $yesNo) => $yesNo->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpEthicalLegalDictionary::COMMERCIAL_DATA_PROTECTION_MEASURES->value, TextareaType::class, [
                'required' => false,
                'label' => DmpEthicalLegalDictionary::COMMERCIAL_DATA_PROTECTION_MEASURES->label(),
                'help' => DmpEthicalLegalDictionary::COMMERCIAL_DATA_PROTECTION_MEASURES->help(),
                'attr' => ['rows' => '5'],
            ])
            ->add(DmpEthicalLegalDictionary::COPYRIGHT->value, EnumType::class, [
                'required' => false,
                'label' => DmpEthicalLegalDictionary::COPYRIGHT->label(),
                'help' => DmpEthicalLegalDictionary::COPYRIGHT->help(),
                'class' => YesNo::class,
                'placeholder' => DmpEthicalLegalDictionary::COPYRIGHT->placeholder(),
                'choice_label' => fn (YesNo $yesNo) => $yesNo->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpEthicalLegalDictionary::COPYRIGHT_LICENSES->value, TextareaType::class, [
                'required' => false,
                'label' => DmpEthicalLegalDictionary::COPYRIGHT_LICENSES->label(),
                'help' => DmpEthicalLegalDictionary::COPYRIGHT_LICENSES->help(),
                'attr' => ['rows' => '5'],
            ])
            ->add(DmpEthicalLegalDictionary::THIRD_PARTY_RIGHTS->value, EnumType::class, [
                'required' => false,
                'label' => DmpEthicalLegalDictionary::THIRD_PARTY_RIGHTS->label(),
                'help' => DmpEthicalLegalDictionary::THIRD_PARTY_RIGHTS->help(),
                'class' => YesNo::class,
                'placeholder' => DmpEthicalLegalDictionary::THIRD_PARTY_RIGHTS->placeholder(),
                'choice_label' => fn (YesNo $yesNo) => $yesNo->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpEthicalLegalDictionary::THIRD_PARTY_LICENSES->value, TextareaType::class, [
                'required' => false,
                'label' => DmpEthicalLegalDictionary::THIRD_PARTY_LICENSES->label(),
                'help' => DmpEthicalLegalDictionary::THIRD_PARTY_LICENSES->help(),
                'attr' => ['rows' => '5'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DmpEthicalLegal::class,
            'translation_domain' => 'forms',
        ]);
    }
}
