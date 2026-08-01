<?php

declare(strict_types=1);

namespace App\Form\Project;

use App\Entity\DataManagementPlan\DataManagementPlan;
use App\Entity\Project\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectDataManagementPlansType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('dataManagementPlans', EntityType::class, [
            'class' => DataManagementPlan::class,
            'choices' => $options['data_management_plan_choices'],
            'multiple' => true,
            'expanded' => true,
            'by_reference' => false,
            'required' => false,
            'label' => 'project.data_management_plans.list.label',
            'choice_label' => fn (DataManagementPlan $dataManagementPlan) => $dataManagementPlan->getSettings()?->getShortName()
                ?? (string) $dataManagementPlan->getId(),
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
            'translation_domain' => 'forms',
            'data_management_plan_choices' => [],
        ]);
        $resolver->setAllowedTypes('data_management_plan_choices', 'array');
    }
}
