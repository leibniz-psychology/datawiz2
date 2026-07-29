<?php

declare(strict_types=1);

namespace App\Form\DataManagementPlan;

use App\Entity\DataManagementPlan\DmpDocumentation;
use App\Enum\DataManagementPlan\Dictionary\DmpDocumentationDictionary;
use App\Enum\DataManagementPlan\DocumentationPurpose;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DmpDocumentationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(DmpDocumentationDictionary::PURPOSE->value, EnumType::class, [
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'label' => DmpDocumentationDictionary::PURPOSE->label(),
                'class' => DocumentationPurpose::class,
                'placeholder' => false,
                'label_html' => true,
                'choice_label' => fn (DocumentationPurpose $purpose) => $purpose->labelExtended(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpDocumentationDictionary::CONTENT->value, TextareaType::class, [
                'required' => false,
                'label' => DmpDocumentationDictionary::CONTENT->label(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpDocumentationDictionary::STANDARDIZATION->value, TextareaType::class, [
                'required' => false,
                'label' => DmpDocumentationDictionary::STANDARDIZATION->label(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpDocumentationDictionary::GENERATING_PROCEDURE->value, TextareaType::class, [
                'required' => false,
                'label' => DmpDocumentationDictionary::GENERATING_PROCEDURE->label(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpDocumentationDictionary::MONITORING->value, TextareaType::class, [
                'required' => false,
                'label' => DmpDocumentationDictionary::MONITORING->label(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpDocumentationDictionary::EXCHANGE_AND_STORAGE_FORMAT->value, TextareaType::class, [
                'required' => false,
                'label' => DmpDocumentationDictionary::EXCHANGE_AND_STORAGE_FORMAT->label(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DmpDocumentation::class,
            'translation_domain' => 'forms',
        ]);
    }
}
