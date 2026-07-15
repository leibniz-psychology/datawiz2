<?php

declare(strict_types=1);

namespace App\Form\DataManagementPlan;

use App\Entity\DataManagementPlan\DmpAdministrativeData;
use App\Enum\DataManagementPlan\Dictionary\DmpAdministrativeDataDictionary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DmpNewType extends AbstractType
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
