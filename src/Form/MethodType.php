<?php

namespace App\Form;

use App\Entity\Constant\MetaDataDictionary;
use App\Entity\Study\MethodMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MethodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(MetaDataDictionary::SETTING, ChoiceType::class, [
                'required' => false,
                'placeholder' => false,
                'choices' => [
                    'input.setting.choices.artificial' => 'Artificial setting',
                    'input.setting.choices.rl' => 'Real-life setting',
                    'input.setting.choices.natural' => 'Natural setting',
                ],
                'expanded' => true,
                'label' => 'input.setting.label',
            ])
            ->add('settingLocation', TextareaType::class, [
                'required' => false,
                'label' => 'input.setting.location.label',
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(MetaDataDictionary::RESEARCH_DESIGN, ChoiceType::class, [
                'required' => false,
                'placeholder' => false,
                'choices' => [
                    'input.design.choices.experimental' => 'Experimental',
                    'input.design.choices.non-experimental' => 'Non-experimental',
                ],
                'expanded' => true,
                'label' => 'input.design.label',
                'label_html' => true,
            ])
            ->add('experimentalDetails', ChoiceType::class, [
                'required' => false,
                'placeholder' => false,
                'choices' => [
                    'input.design.details.experimental.choices.random-assignment' => 'Random assignment',
                    'input.design.details.experimental.choices.non-random-assignment' => 'Non-random assignment',
                    'input.design.details.experimental.choices.clinical-trial' => 'Clinical trial',
                ],
                'expanded' => true,
                'label' => 'input.design.details.experimental.label',
                'label_html' => true,
            ])
            ->add('nonExperimentalDetails', ChoiceType::class, [
                'required' => false,
                'placeholder' => false,
                'choices' => [
                    'input.design.details.non-experimental.choices.observational-study' => 'Observational study',
                    'input.design.details.non-experimental.choices.survey-research' => 'Survey research',
                    'input.design.details.non-experimental.choices.correlational-research' => 'Correlational research',
                    'input.design.details.non-experimental.choices.causal-comparative-research' => 'Causal-comparative research',
                    'input.design.details.non-experimental.choices.single-case' => 'Single case',
                ],
                'expanded' => true,
                'label' => 'input.design.details.non-experimental.label',
                'label_html' => true,
            ])
            ->add('observationalType', ChoiceType::class, [
                'required' => false,
                'placeholder' => 'input.design.details.observationalType.placeholder',
                'choices' => [
                    'input.design.details.observationalType.choices.cohort-study' => 'Cohort study',
                    'input.design.details.observationalType.choices.case-control-study' => 'Case-control study',
                    'input.design.details.observationalType.choices.cross-sectional-study' => 'Cross-sectional study',
                ],
                'label' => 'input.design.details.observationalType.label',
            ])
            ->add(MetaDataDictionary::MANIPULATIONS, TextareaType::class, [
                'required' => false,
                'label' => 'input.manipulations.label',
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add(MetaDataDictionary::EXPERIMENTAL_DESIGN, ChoiceType::class, [
                'required' => false,
                'placeholder' => false,
                'choices' => [
                    'input.experimental-design.choices.independent' => 'Independent measures / between-subjects design',
                    'input.experimental-design.choices.repeated' => 'Repeated measures / within-subjects design',
                    'input.experimental-design.choices.matched' => 'Matched pairs design',
                ],
                'expanded' => true,
                'label' => 'input.experimental-design.label',
            ])
            ->add(MetaDataDictionary::CONTROL_OPERATIONS, ChoiceType::class, [
                'required' => false,
                'placeholder' => false,
                'choices' => [
                    'input.control-operations.choices.none' => 'None',
                    'input.control-operations.choices.block' => 'Block randomization',
                    'input.control-operations.choices.complete' => 'Complete counterbalancing (all possible orders)',
                    'input.control-operations.choices.incomplete' => 'Incomplete counterbalancing (partial counterbalancing)',
                    'input.control-operations.choices.latin-square' => 'Latin Square',
                    'input.control-operations.choices.rng-latin-square' => 'Latin Square using a random starting order with rotation (rotate order)',
                    'input.control-operations.choices.reverse' => 'Reverse counterbalancing (ABBA-counterbalancing)',
                    'input.control-operations.choices.other' => 'Other',
                ],
                'expanded' => true,
                'label' => 'input.control-operations.label',
            ])
            ->add('otherControlOperations', TextareaType::class, [
                'required' => false,
                'label' => 'input.control-operations.other.label',
                'attr' => ['rows' => '4'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => MethodMetaDataGroup::class]);
    }
}
