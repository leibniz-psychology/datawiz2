<?php

declare(strict_types=1);

namespace App\Form\DataManagementPlan;

use App\Entity\DataManagementPlan\DmpStorageInfrastructure;
use App\Enum\DataManagementPlan\Dictionary\DmpStorageInfrastructureDictionary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DmpStorageInfrastructureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(DmpStorageInfrastructureDictionary::RESPONSIBILITIES->value, TextareaType::class, [
                'required' => false,
                'label' => DmpStorageInfrastructureDictionary::RESPONSIBILITIES->label(),
                'help' => DmpStorageInfrastructureDictionary::RESPONSIBILITIES->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpStorageInfrastructureDictionary::NAMING_CONVENTIONS->value, TextareaType::class, [
                'required' => false,
                'label' => DmpStorageInfrastructureDictionary::NAMING_CONVENTIONS->label(),
                'help' => DmpStorageInfrastructureDictionary::NAMING_CONVENTIONS->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpStorageInfrastructureDictionary::STORAGE_LOCATIONS->value, TextareaType::class, [
                'required' => false,
                'label' => DmpStorageInfrastructureDictionary::STORAGE_LOCATIONS->label(),
                'help' => DmpStorageInfrastructureDictionary::STORAGE_LOCATIONS->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpStorageInfrastructureDictionary::BACKUP_PLAN->value, TextareaType::class, [
                'required' => false,
                'label' => DmpStorageInfrastructureDictionary::BACKUP_PLAN->label(),
                'help' => DmpStorageInfrastructureDictionary::BACKUP_PLAN->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpStorageInfrastructureDictionary::TRANSFER_DURING_PROJECT->value, TextareaType::class, [
                'required' => false,
                'label' => DmpStorageInfrastructureDictionary::TRANSFER_DURING_PROJECT->label(),
                'help' => DmpStorageInfrastructureDictionary::TRANSFER_DURING_PROJECT->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpStorageInfrastructureDictionary::EXPECTED_VOLUME->value, TextareaType::class, [
                'required' => false,
                'label' => DmpStorageInfrastructureDictionary::EXPECTED_VOLUME->label(),
                'help' => DmpStorageInfrastructureDictionary::EXPECTED_VOLUME->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpStorageInfrastructureDictionary::SPECIFIC_TECHNICAL_REQUIREMENTS->value, TextareaType::class, [
                'required' => false,
                'label' => DmpStorageInfrastructureDictionary::SPECIFIC_TECHNICAL_REQUIREMENTS->label(),
                'help' => DmpStorageInfrastructureDictionary::SPECIFIC_TECHNICAL_REQUIREMENTS->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpStorageInfrastructureDictionary::SUCCESSION_PLAN->value, TextareaType::class, [
                'required' => false,
                'label' => DmpStorageInfrastructureDictionary::SUCCESSION_PLAN->label(),
                'help' => DmpStorageInfrastructureDictionary::SUCCESSION_PLAN->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DmpStorageInfrastructure::class,
            'translation_domain' => 'forms',
        ]);
    }
}
