<?php

namespace App\Questionnaire\Forms;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Model\Study\MethodMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => ['class' => 'p-1'],
                'choice_attr' => fn() => ['class' => 'RadioButton-Input'],
            ])
            ->add("settingLocation", TextareaType::class, [
                'required' => false,
                'label' => 'input.setting.location.label',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput disabled:opacity-50',
                    'rows' => '3',
                    'x-data' => '',
                    ':disabled' => '$store.app.settingType === `Artificial setting` || $store.app.settingType === undefined',
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
                'help' => '',
                'label_attr' => ['class' => 'MetaData-Label'],
                'help_attr' => ['class' => 'px-6 pt-1'],
                'attr' => ['class' => 'p-1'],
                'choice_attr' => fn() => [
                    'class' => 'RadioButton-Input',
                ],
            ])
            ->add("experimentalDetails", ChoiceType::class, [
                'required' => false,
                'placeholder' => false,
                'choices' => [
                    'input.design.details.experimental.choices.random-assignment' => 'Random assignment',
                    'input.design.details.experimental.choices.non-random-assignment' => 'Non-random assignment',
                    'input.design.details.experimental.choices.clinical-trial' => 'Clinical trial',
                ],
                'expanded' => true,
                'label' => 'input.design.details.experimental.label',
                'label_attr' => ['class' => 'MetaData-Label !pl-0'],
                'label_html' => true,
                'attr' => ['class' => 'p-1'],
                'choice_attr' => fn() => [
                    'class' => 'RadioButton-Input',
                ],
            ])
            ->add("nonExperimentalDetails", ChoiceType::class, [
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
                'label_attr' => ['class' => 'MetaData-Label !pl-0'],
                'label_html' => true,
                'attr' => ['class' => 'p-1'],
                'choice_attr' => fn() => [
                    'class' => 'RadioButton-Input',
                ],
            ])
            ->add("observationalType", ChoiceType::class, [
                'required' => false,
                'placeholder' => 'input.design.details.observationalType.placeholder',
                'choices' => [
                    'input.design.details.observationalType.choices.cohort-study' => 'Cohort study',
                    'input.design.details.observationalType.choices.case-control-study' => 'Case-control study',
                    'input.design.details.observationalType.choices.cross-sectional-study' => 'Cross-sectional study',
                ],
                'label' => 'input.design.details.observationalType.label',
                'attr' => ['class' => 'p-1'],
            ])
            ->add(MetaDataDictionary::MANIPULATIONS, TextareaType::class, [
                'required' => false,
                'label' => 'input.manipulations.label',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
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
                'attr' => ['class' => 'p-1'],
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
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => ['class' => 'p-1'],
                'choice_attr' => fn() => ['class' => 'RadioButton-Input'],
            ])
            ->add("otherControlOperations", TextareaType::class, [
                'required' => false,
                'label' => 'input.control-operations.other.label',
                'attr' => ['class' => 'p-1', 'rows' => '4',],
            ])
            ->add('saveAndPrevious', SubmitType::class)
            ->add('saveAndNext', SubmitType::class)
            ->add('saveAndIntroduction', SubmitType::class, [
                'label' => 'input.hidden',
                'attr' => [
                    'class' => 'hidden Button_saveAndIntroduction',
                ],
            ])
            ->add('saveAndDocumentation', SubmitType::class, [
                'label' => 'input.hidden',
                'attr' => [
                    'class' => 'hidden Button_saveAndDocumentation',
                ],
            ])
            ->add('saveAndTheory', SubmitType::class, [
                'label' => 'input.hidden',
                'attr' => [
                    'class' => 'hidden Button_saveAndTheory',
                ],
            ])
            ->add('saveAndMethod', SubmitType::class, [
                'label' => 'input.hidden',
                'attr' => [
                    'class' => 'hidden Button_saveAndMethod',
                ],
            ])
            ->add('saveAndMeasure', SubmitType::class, [
                'label' => 'input.hidden',
                'attr' => [
                    'class' => 'hidden Button_saveAndMeasure',
                ],
            ])
            ->add('saveAndSample', SubmitType::class, [
                'label' => 'input.hidden',
                'attr' => [
                    'class' => 'hidden Button_saveAndSample',
                ],
            ])
            ->add('saveAndDatasets', SubmitType::class, [
                'label' => 'input.hidden',
                'attr' => [
                    'class' => 'hidden Button_saveAndDatasets',
                ],
            ])
            ->add('saveAndMaterials', SubmitType::class, [
                'label' => 'input.hidden',
                'attr' => [
                    'class' => 'hidden Button_saveAndMaterials',
                ],
            ])
            ->add('saveAndReview', SubmitType::class, [
                'label' => 'input.hidden',
                'attr' => [
                    'class' => 'hidden Button_saveAndReview',
                ],
            ])
            ->add('saveAndExport', SubmitType::class, [
                'label' => 'input.hidden',
                'attr' => [
                    'class' => 'hidden Button_saveAndExport',
                ],
            ])
            ->add('saveAndSettings', SubmitType::class, [
                'label' => 'input.hidden',
                'attr' => [
                    'class' => 'hidden Button_saveAndSettings',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => MethodMetaDataGroup::class]);
    }
}
