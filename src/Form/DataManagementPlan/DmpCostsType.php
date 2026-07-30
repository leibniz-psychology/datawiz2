<?php

declare(strict_types=1);

namespace App\Form\DataManagementPlan;

use App\Entity\DataManagementPlan\DmpCosts;
use App\Enum\DataManagementPlan\DataManagementCosting;
use App\Enum\DataManagementPlan\Dictionary\DmpCostsDictionary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DmpCostsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(DmpCostsDictionary::DATA_MANAGEMENT_COSTING->value, EnumType::class, [
                'required' => false,
                'label' => DmpCostsDictionary::DATA_MANAGEMENT_COSTING->label(),
                'help' => DmpCostsDictionary::DATA_MANAGEMENT_COSTING->help(),
                'class' => DataManagementCosting::class,
                'placeholder' => false,
                'choice_label' => fn (DataManagementCosting $costing) => $costing->label(),
                'choice_translation_domain' => 'enums',
                'expanded' => true,
            ])
            ->add(DmpCostsDictionary::COSTS_ASSESSMENT->value, TextareaType::class, [
                'required' => false,
                'label' => DmpCostsDictionary::COSTS_ASSESSMENT->label(),
                'help' => DmpCostsDictionary::COSTS_ASSESSMENT->help(),
                'attr' => ['rows' => '5'],
            ])
            ->add(DmpCostsDictionary::COSTS_ASSUMPTION->value, TextareaType::class, [
                'required' => false,
                'label' => DmpCostsDictionary::COSTS_ASSUMPTION->label(),
                'help' => DmpCostsDictionary::COSTS_ASSUMPTION->help(),
                'attr' => ['rows' => '5'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DmpCosts::class,
            'translation_domain' => 'forms',
        ]);
    }
}
