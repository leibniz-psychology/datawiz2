<?php

namespace App\Questionnaire\Forms;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Model\Study\MethodMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Parsedown;

class MethodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $Parsedown = new Parsedown();

        $builder
            ->add(MetaDataDictionary::SETTING, ChoiceType::class, [
                'required' => false,
                'placeholder' => false,
                'choices' => [
                    $Parsedown->line(
                        '<span>Artificial setting</span>
                        <span>Artificial setting (e.g. laboratory experiment) {.hidden}</span> '
                    ) => 'Artificial setting',
                    $Parsedown->line(
                        '<span>Real-life setting</span>
                        <span>Real-life setting (e.g., field experiment)</span>'
                    ) => 'Real-life setting',
                    $Parsedown->line(
                        '<span>Natural setting</span>
                        <span>Natural setting (e.g., natural observations)</span>'
                    ) => 'Natural setting',
                ],
                'expanded' => true,
                'label' => 'Choose your setting',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'p-1',
                ],
                'choice_attr' => function () {
                    return ['class' => 'RadioButton-Input'];
                }
            ])
            ->add("settingLocation", TextareaType::class, [
                'required' => false,
                'label' => 'Enter the location where your study took place',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                ]
            ])
            ->add(MetaDataDictionary::RESEARCH_DESIGN, ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'Experimental' => 'Experimental',
                    'Non-Experimental' => 'Non-Experimental',
                ],
                'expanded' => true,
                'label' => 'Research design',
                'help' => '',
                'label_attr' => ['class' => 'MetaData-Title'],
                'help_attr' => ['class' => 'px-6 pt-1'],
                'attr' => [
                    'class' => 'p-1',
                ]
            ])
            ->add("experimentalDetails", ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'Random assignment' => 'Random assignment',
                    'Non-random assignment' => 'Non-random assignment',
                    'Clinical trial' => 'Clinical trial',
                ],
                'expanded' => true,
                'label_attr' => ['class' => 'MetaData-Title'],
                'help_attr' => ['class' => 'px-6 pt-1'],
                'attr' => [
                    'class' => 'p-1',
                ]
            ])
            ->add("nonExperimentalDetails", ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'Observational Study' => 'Observational Study',
                    'Survey research' => 'Survey research',
                    'Correlational research' => 'Correlational research',
                    'Causal-comparative research' => 'Causal-comparative research',
                    'Single case' => 'Single case',
                ],
                'expanded' => true,
                'label_attr' => ['class' => 'MetaData-Title'],
                'help_attr' => ['class' => 'px-6 pt-1'],
                'attr' => [
                    'class' => 'p-1',
                ]
            ])
            ->add("observationalType", ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'Cohort Study' => 'Cohort Study',
                    'Case-control Study' => 'Case-control Study',
                    'Cross-sectional Study' => 'Cross-sectional Study',
                ],
                'label_attr' => ['class' => 'MetaData-Title'],
                'help_attr' => ['class' => 'px-6 pt-1'],
                'attr' => [
                    'class' => 'p-1',
                ]
            ])
            ->add(MetaDataDictionary::MANIPULATIONS, TextareaType::class, [
                'required' => false,
                'label' => 'Provide details of your experimental manipulation(s) including a summary of the instructions. Clearly define your variables (treatments).',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                ]
            ])
            ->add(MetaDataDictionary::EXPERIMENTAL_DESIGN, ChoiceType::class, [

                'required' => false,
                'placeholder' => false,
                'choices' => [
                    'Independent measures / between-subjects design' => 'Independent measures / between-subjects design',
                    'Repeated measures / within-subjects design' => 'Repeated measures / within-subjects design',
                    'Matched pairs design' => 'Matched pairs design'
                ],
                'expanded' => true,
                'label' => 'How were participants allocated to the different conditions?',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'p-1',
                ],
                'choice_attr' => function () {
                    return ['class' => 'RadioButton-Input'];
                }
            ])
            ->add(MetaDataDictionary::CONTROL_OPERATIONS, ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'Block randomization' => 'Block randomization',
                    'Complete counterbalancing (all possible orders)' => 'Complete counterbalancing (all possible orders)',
                    'Incomplete counterbalancing (partial counterbalancing)' => 'Incomplete counterbalancing (partial counterbalancing)',
                    'Latin Square' => 'Latin Square',
                    'Latin Square using a random starting order with rotation (rotate order)' => 'Latin Square using a random starting order with rotation (rotate order)',
                    'Reverse counterbalancing (ABBA-counterbalancing)' => 'Reverse counterbalancing (ABBA-counterbalancing)',
                    'Other' => 'Other'
                ],
                'expanded' => true,
                'label' => 'Describes the actions taken to prevent sampling and order effects',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'p-1',
                ],
                'choice_attr' => function () {
                    return ['class' => 'RadioButton-Input'];
                }
            ])
            ->add("otherControlOperations", TextareaType::class, [
                'required' => false,
                'label' => 'Other Control Operations',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                ]
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MethodMetaDataGroup::class,
        ]);
    }
}
