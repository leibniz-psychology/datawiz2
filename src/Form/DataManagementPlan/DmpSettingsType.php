<?php

declare(strict_types=1);

namespace App\Form\DataManagementPlan;

use App\Entity\DataManagementPlan\DmpSettings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DmpSettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('shortName', TextType::class, [
                'required' => true,
                'label' => 'data_management_plan.settings.short_name.label',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DmpSettings::class,
            'translation_domain' => 'forms',
        ]);
    }
}
