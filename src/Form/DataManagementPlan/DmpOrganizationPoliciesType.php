<?php

declare(strict_types=1);

namespace App\Form\DataManagementPlan;

use App\Entity\DataManagementPlan\DmpOrganizationPolicies;
use App\Enum\DataManagementPlan\Dictionary\DmpOrganizationPoliciesDictionary;
use App\Enum\YesNo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DmpOrganizationPoliciesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(DmpOrganizationPoliciesDictionary::CROSS_BORDER_COLLABORATION->value, EnumType::class, [
                'required' => false,
                'label' => DmpOrganizationPoliciesDictionary::CROSS_BORDER_COLLABORATION->label(),
                'help' => DmpOrganizationPoliciesDictionary::CROSS_BORDER_COLLABORATION->help(),
                'class' => YesNo::class,
                'placeholder' => DmpOrganizationPoliciesDictionary::CROSS_BORDER_COLLABORATION->placeholder(),
                'choice_label' => fn (YesNo $yesNo) => $yesNo->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpOrganizationPoliciesDictionary::CROSS_BORDER_DATA_MANAGEMENT_REQUIREMENTS->value, TextareaType::class, [
                'required' => false,
                'label' => DmpOrganizationPoliciesDictionary::CROSS_BORDER_DATA_MANAGEMENT_REQUIREMENTS->label(),
                'help' => DmpOrganizationPoliciesDictionary::CROSS_BORDER_DATA_MANAGEMENT_REQUIREMENTS->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpOrganizationPoliciesDictionary::DATA_MANAGEMENT_RESPONSIBILITIES->value, TextareaType::class, [
                'required' => false,
                'label' => DmpOrganizationPoliciesDictionary::DATA_MANAGEMENT_RESPONSIBILITIES->label(),
                'help' => DmpOrganizationPoliciesDictionary::DATA_MANAGEMENT_RESPONSIBILITIES->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpOrganizationPoliciesDictionary::DATA_MANAGEMENT_PARTNERS->value, TextareaType::class, [
                'required' => false,
                'label' => DmpOrganizationPoliciesDictionary::DATA_MANAGEMENT_PARTNERS->label(),
                'help' => DmpOrganizationPoliciesDictionary::DATA_MANAGEMENT_PARTNERS->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpOrganizationPoliciesDictionary::PARTNER_INFORMED->value, EnumType::class, [
                'required' => false,
                'label' => DmpOrganizationPoliciesDictionary::PARTNER_INFORMED->label(),
                'help' => DmpOrganizationPoliciesDictionary::PARTNER_INFORMED->help(),
                'class' => YesNo::class,
                'placeholder' => DmpOrganizationPoliciesDictionary::PARTNER_INFORMED->placeholder(),
                'choice_label' => fn (YesNo $yesNo) => $yesNo->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpOrganizationPoliciesDictionary::PARTNER_CONTRIBUTIONS_DEFINED->value, EnumType::class, [
                'required' => false,
                'label' => DmpOrganizationPoliciesDictionary::PARTNER_CONTRIBUTIONS_DEFINED->label(),
                'help' => DmpOrganizationPoliciesDictionary::PARTNER_CONTRIBUTIONS_DEFINED->help(),
                'class' => YesNo::class,
                'placeholder' => DmpOrganizationPoliciesDictionary::PARTNER_CONTRIBUTIONS_DEFINED->placeholder(),
                'choice_label' => fn (YesNo $yesNo) => $yesNo->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpOrganizationPoliciesDictionary::PARTNER_CONTRIBUTIONS->value, TextareaType::class, [
                'required' => false,
                'label' => DmpOrganizationPoliciesDictionary::PARTNER_CONTRIBUTIONS->label(),
                'help' => DmpOrganizationPoliciesDictionary::PARTNER_CONTRIBUTIONS->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpOrganizationPoliciesDictionary::PARTNER_CONTRIBUTIONS_RESPONSIBILITY_ACCEPTANCE->value, EnumType::class, [
                'required' => false,
                'label' => DmpOrganizationPoliciesDictionary::PARTNER_CONTRIBUTIONS_RESPONSIBILITY_ACCEPTANCE->label(),
                'help' => DmpOrganizationPoliciesDictionary::PARTNER_CONTRIBUTIONS_RESPONSIBILITY_ACCEPTANCE->help(),
                'class' => YesNo::class,
                'placeholder' => DmpOrganizationPoliciesDictionary::PARTNER_CONTRIBUTIONS_RESPONSIBILITY_ACCEPTANCE->placeholder(),
                'choice_label' => fn (YesNo $yesNo) => $yesNo->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpOrganizationPoliciesDictionary::DATA_MANAGEMENT_WORKFLOW_DESCRIPTION->value, TextareaType::class, [
                'required' => false,
                'label' => DmpOrganizationPoliciesDictionary::DATA_MANAGEMENT_WORKFLOW_DESCRIPTION->label(),
                'help' => DmpOrganizationPoliciesDictionary::DATA_MANAGEMENT_WORKFLOW_DESCRIPTION->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpOrganizationPoliciesDictionary::STAFF_RESOURCE_ASSESSMENT->value, TextareaType::class, [
                'required' => false,
                'label' => DmpOrganizationPoliciesDictionary::STAFF_RESOURCE_ASSESSMENT->label(),
                'help' => DmpOrganizationPoliciesDictionary::STAFF_RESOURCE_ASSESSMENT->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpOrganizationPoliciesDictionary::INSTITUTION_POLICIES->value, TextareaType::class, [
                'required' => false,
                'label' => DmpOrganizationPoliciesDictionary::INSTITUTION_POLICIES->label(),
                'help' => DmpOrganizationPoliciesDictionary::INSTITUTION_POLICIES->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(DmpOrganizationPoliciesDictionary::DATA_MANAGEMENT_PLAN_ADHERENCE->value, TextareaType::class, [
                'required' => false,
                'label' => DmpOrganizationPoliciesDictionary::DATA_MANAGEMENT_PLAN_ADHERENCE->label(),
                'help' => DmpOrganizationPoliciesDictionary::DATA_MANAGEMENT_PLAN_ADHERENCE->help(),
                'attr' => [
                    'rows' => '5',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DmpOrganizationPolicies::class,
            'translation_domain' => 'forms',
        ]);
    }
}
