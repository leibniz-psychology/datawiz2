<?php

declare(strict_types=1);

namespace App\Form\DataManagementPlan;

use App\Entity\DataManagementPlan\DmpAdministrativeData;
use App\Enum\DataManagementPlan\Dictionary\DmpAdministrativeDataDictionary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DmpAdministrativeDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(DmpAdministrativeDataDictionary::PROJECT_NAME->value, TextType::class, [
                'required' => false,
                'label' => DmpAdministrativeDataDictionary::PROJECT_NAME->label(),
                'attr' => [
                    'placeholder' => DmpAdministrativeDataDictionary::PROJECT_NAME->placeholder(),
                ],
            ])
            ->add(DmpAdministrativeDataDictionary::PROJECT_GOALS->value, TextareaType::class, [
                'required' => false,
                'label' => DmpAdministrativeDataDictionary::PROJECT_GOALS->label(),
                'attr' => [
                    'rows' => '5',
                    'placeholder' => DmpAdministrativeDataDictionary::PROJECT_GOALS->placeholder(),
                ],
            ])
            ->add(DmpAdministrativeDataDictionary::FUNDING->value, TextType::class, [
                'required' => false,
                'label' => DmpAdministrativeDataDictionary::FUNDING->label(),
                'attr' => [
                    'placeholder' => DmpAdministrativeDataDictionary::FUNDING->placeholder(),
                ],
            ])
            ->add(DmpAdministrativeDataDictionary::PROJECT_DURATION->value, TextType::class, [
                'required' => false,
                'label' => DmpAdministrativeDataDictionary::PROJECT_DURATION->label(),
                'help' => DmpAdministrativeDataDictionary::PROJECT_DURATION->help(),
                'attr' => [
                    'placeholder' => DmpAdministrativeDataDictionary::PROJECT_DURATION->placeholder(),
                ],
            ])
            ->add(DmpAdministrativeDataDictionary::PROJECT_PARTNERS->value, TextType::class, [
                'required' => false,
                'label' => DmpAdministrativeDataDictionary::PROJECT_PARTNERS->label(),
                'help' => DmpAdministrativeDataDictionary::PROJECT_PARTNERS->help(),
                'attr' => [
                    'placeholder' => DmpAdministrativeDataDictionary::PROJECT_PARTNERS->placeholder(),
                ],
            ])
            ->add(DmpAdministrativeDataDictionary::PRINCIPAL_INVESTIGATOR->value, TextType::class, [
                'required' => false,
                'label' => DmpAdministrativeDataDictionary::PRINCIPAL_INVESTIGATOR->label(),
                'attr' => [
                    'placeholder' => DmpAdministrativeDataDictionary::PRINCIPAL_INVESTIGATOR->placeholder(),
                ],
            ])
            ->add(DmpAdministrativeDataDictionary::TARGET_AUDIENCES->value, TextareaType::class, [
                'required' => false,
                'label' => DmpAdministrativeDataDictionary::TARGET_AUDIENCES->label(),
                'help' => DmpAdministrativeDataDictionary::TARGET_AUDIENCES->help(),
                'attr' => [
                    'rows' => '5',
                    'placeholder' => DmpAdministrativeDataDictionary::TARGET_AUDIENCES->placeholder(),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DmpAdministrativeData::class,
            'translation_domain' => 'forms',
        ]);
    }
}
