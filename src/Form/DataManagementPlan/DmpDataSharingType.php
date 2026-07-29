<?php

declare(strict_types=1);

namespace App\Form\DataManagementPlan;

use App\Entity\DataManagementPlan\DmpDataSharing;
use App\Enum\DataManagementPlan\Dictionary\DmpDataSharingDictionary;
use App\Enum\DataManagementPlan\NoSharingExplanation;
use App\Enum\DataManagementPlan\PersistentIdentifierUse;
use App\Enum\DataManagementPlan\ThirdPartyAccess;
use App\Enum\YesNo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DmpDataSharingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(DmpDataSharingDictionary::SHARING_OBLIGATION->value, EnumType::class, [
                'required' => false,
                'label' => DmpDataSharingDictionary::SHARING_OBLIGATION->label(),
                'help' => DmpDataSharingDictionary::SHARING_OBLIGATION->help(),
                'class' => YesNo::class,
                'placeholder' => DmpDataSharingDictionary::SHARING_OBLIGATION->placeholder(),
                'choice_label' => fn (YesNo $yesNo) => $yesNo->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpDataSharingDictionary::INTENDED_USE->value, TextareaType::class, [
                'required' => false,
                'label' => DmpDataSharingDictionary::INTENDED_USE->label(),
                'help' => DmpDataSharingDictionary::INTENDED_USE->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpDataSharingDictionary::THIRD_PARTY_ACCESS->value, EnumType::class, [
                'required' => false,
                'expanded' => true,
                'label' => DmpDataSharingDictionary::THIRD_PARTY_ACCESS->label(),
                'help' => DmpDataSharingDictionary::THIRD_PARTY_ACCESS->help(),
                'class' => ThirdPartyAccess::class,
                'placeholder' => false,
                'choice_label' => fn (ThirdPartyAccess $access) => $access->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpDataSharingDictionary::REPOSITORY_NAME->value, TextareaType::class, [
                'required' => false,
                'label' => DmpDataSharingDictionary::REPOSITORY_NAME->label(),
                'help' => DmpDataSharingDictionary::REPOSITORY_NAME->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpDataSharingDictionary::DATA_SEARCHABILITY->value, TextareaType::class, [
                'required' => false,
                'label' => DmpDataSharingDictionary::DATA_SEARCHABILITY->label(),
                'help' => DmpDataSharingDictionary::DATA_SEARCHABILITY->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpDataSharingDictionary::DEPOSIT_TIMEPOINT->value, TextareaType::class, [
                'required' => false,
                'label' => DmpDataSharingDictionary::DEPOSIT_TIMEPOINT->label(),
                'help' => DmpDataSharingDictionary::DEPOSIT_TIMEPOINT->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpDataSharingDictionary::SENSITIVE_DATA_REQUIREMENTS->value, TextareaType::class, [
                'required' => false,
                'label' => DmpDataSharingDictionary::SENSITIVE_DATA_REQUIREMENTS->label(),
                'help' => DmpDataSharingDictionary::SENSITIVE_DATA_REQUIREMENTS->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpDataSharingDictionary::INITIAL_USE_RIGHT->value, TextareaType::class, [
                'required' => false,
                'label' => DmpDataSharingDictionary::INITIAL_USE_RIGHT->label(),
                'help' => DmpDataSharingDictionary::INITIAL_USE_RIGHT->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpDataSharingDictionary::USAGE_RESTRICTION->value, TextareaType::class, [
                'required' => false,
                'label' => DmpDataSharingDictionary::USAGE_RESTRICTION->label(),
                'help' => DmpDataSharingDictionary::USAGE_RESTRICTION->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpDataSharingDictionary::ACCESS_COST->value, EnumType::class, [
                'required' => false,
                'label' => DmpDataSharingDictionary::ACCESS_COST->label(),
                'help' => DmpDataSharingDictionary::ACCESS_COST->help(),
                'class' => YesNo::class,
                'placeholder' => DmpDataSharingDictionary::ACCESS_COST->placeholder(),
                'choice_label' => fn (YesNo $yesNo) => $yesNo->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpDataSharingDictionary::REPOSITORY_RESPONSIBILITIES_FIXATION->value, EnumType::class, [
                'required' => false,
                'label' => DmpDataSharingDictionary::REPOSITORY_RESPONSIBILITIES_FIXATION->label(),
                'help' => DmpDataSharingDictionary::REPOSITORY_RESPONSIBILITIES_FIXATION->help(),
                'class' => YesNo::class,
                'placeholder' => DmpDataSharingDictionary::REPOSITORY_RESPONSIBILITIES_FIXATION->placeholder(),
                'choice_label' => fn (YesNo $yesNo) => $yesNo->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpDataSharingDictionary::ACQUISITION_AGREEMENT->value, EnumType::class, [
                'required' => false,
                'label' => DmpDataSharingDictionary::ACQUISITION_AGREEMENT->label(),
                'help' => DmpDataSharingDictionary::ACQUISITION_AGREEMENT->help(),
                'class' => YesNo::class,
                'placeholder' => DmpDataSharingDictionary::ACQUISITION_AGREEMENT->placeholder(),
                'choice_label' => fn (YesNo $yesNo) => $yesNo->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpDataSharingDictionary::PERSISTENT_IDENTIFIER_USE->value, EnumType::class, [
                'required' => false,
                'label' => DmpDataSharingDictionary::PERSISTENT_IDENTIFIER_USE->label(),
                'help' => DmpDataSharingDictionary::PERSISTENT_IDENTIFIER_USE->help(),
                'class' => PersistentIdentifierUse::class,
                'placeholder' => DmpDataSharingDictionary::PERSISTENT_IDENTIFIER_USE->placeholder(),
                'choice_label' => fn (PersistentIdentifierUse $use) => $use->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpDataSharingDictionary::PERSISTENT_IDENTIFIER_USE_OTHER_DESCRIPTION->value, TextareaType::class, [
                'required' => false,
                'label' => DmpDataSharingDictionary::PERSISTENT_IDENTIFIER_USE_OTHER_DESCRIPTION->label(),
                'help' => DmpDataSharingDictionary::PERSISTENT_IDENTIFIER_USE_OTHER_DESCRIPTION->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpDataSharingDictionary::NO_REPOSITORY_EXPLANATION->value, TextareaType::class, [
                'required' => false,
                'label' => DmpDataSharingDictionary::NO_REPOSITORY_EXPLANATION->label(),
                'help' => DmpDataSharingDictionary::NO_REPOSITORY_EXPLANATION->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpDataSharingDictionary::NO_SHARING_EXPLANATION->value, EnumType::class, [
                'required' => false,
                'expanded' => true,
                'label' => DmpDataSharingDictionary::NO_SHARING_EXPLANATION->label(),
                'help' => DmpDataSharingDictionary::NO_SHARING_EXPLANATION->help(),
                'class' => NoSharingExplanation::class,
                'placeholder' => false,
                'choice_label' => fn (NoSharingExplanation $explanation) => $explanation->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpDataSharingDictionary::NO_SHARING_EXPLANATION_OTHER_DESCRIPTION->value, TextareaType::class, [
                'required' => false,
                'label' => DmpDataSharingDictionary::NO_SHARING_EXPLANATION_OTHER_DESCRIPTION->label(),
                'help' => DmpDataSharingDictionary::NO_SHARING_EXPLANATION_OTHER_DESCRIPTION->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DmpDataSharing::class,
            'translation_domain' => 'forms',
        ]);
    }
}
