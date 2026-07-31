<?php

declare(strict_types=1);

namespace App\Form\Project;

use App\Entity\Project\ProjectAdministrativeData;
use App\Enum\Project\Dictionary\ProjectAdministrativeDataDictionary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectAdministrativeDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(ProjectAdministrativeDataDictionary::PROJECT_TITLE->value, TextType::class, [
                'required' => false,
                'label' => ProjectAdministrativeDataDictionary::PROJECT_TITLE->label(),
                'attr' => [
                    'placeholder' => ProjectAdministrativeDataDictionary::PROJECT_TITLE->placeholder(),
                ],
            ])
            ->add(ProjectAdministrativeDataDictionary::PROJECT_ID->value, TextType::class, [
                'required' => false,
                'label' => ProjectAdministrativeDataDictionary::PROJECT_ID->label(),
                'attr' => [
                    'placeholder' => ProjectAdministrativeDataDictionary::PROJECT_ID->placeholder(),
                ],
            ])
            ->add(ProjectAdministrativeDataDictionary::PROJECT_OBJECTIVES->value, TextareaType::class, [
                'required' => false,
                'label' => ProjectAdministrativeDataDictionary::PROJECT_OBJECTIVES->label(),
                'attr' => [
                    'rows' => '5',
                    'placeholder' => ProjectAdministrativeDataDictionary::PROJECT_OBJECTIVES->placeholder(),
                ],
            ])
            ->add(ProjectAdministrativeDataDictionary::FUNDING->value, TextType::class, [
                'required' => false,
                'label' => ProjectAdministrativeDataDictionary::FUNDING->label(),
                'help' => ProjectAdministrativeDataDictionary::FUNDING->help(),
                'attr' => [
                    'placeholder' => ProjectAdministrativeDataDictionary::FUNDING->placeholder(),
                ],
            ])
            ->add(ProjectAdministrativeDataDictionary::GRANT_NUMBER->value, TextType::class, [
                'required' => false,
                'label' => ProjectAdministrativeDataDictionary::GRANT_NUMBER->label(),
                'attr' => [
                    'placeholder' => ProjectAdministrativeDataDictionary::GRANT_NUMBER->placeholder(),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProjectAdministrativeData::class,
            'translation_domain' => 'forms',
        ]);
    }
}
