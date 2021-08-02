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
                        '<span>Artificial setting</span><span>Artificial setting (e.g. laboratory experiment)</span>'
                    ) => 'Artificial setting',
                    $Parsedown->line(
                        '<span>Real-life setting</span><span>Real-life setting (e.g., field experiment)</span>'
                    ) => 'Real-life setting',
                    $Parsedown->line(
                        '<span>Natural setting</span><span>Natural setting (e.g., natural observations)</span>'
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
                'label' => 'For real-life and natural settings enter the location where your study took place',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput disabled:opacity-50',
                    'x-data' => '',
                    ':disabled' => '$store.app.settingType === `Artificial setting` || $store.app.settingType === undefined'
                ]
            ])
            ->add(MetaDataDictionary::RESEARCH_DESIGN, ChoiceType::class, [
                'required' => false,
                'placeholder' => false,
                'choices' => [
                    $Parsedown->line(
                        '<span class="block">Experimental</span><span class="block text-sm">Your study involved an experimental manipulation</span>'
                    ) => 'Experimental',
                    $Parsedown->line(
                        '<span class="block">Non-experimental</span><span class="block text-sm">Your study did not involve an experimental manipulation</span>'
                    ) => 'Non-experimental',
                ],
                'expanded' => true,
                'label' => 'Choose your type of research design',
                'help' => '',
                'label_attr' => ['class' => 'MetaData-Label'],
                'help_attr' => ['class' => 'px-6 pt-1'],
                'attr' => [
                    'class' => 'p-1',
                ],
                'choice_attr' => function () {
                    return [
                        'class' => 'RadioButton-Input',
                    ];
                }
            ])
            ->add("experimentalDetails", ChoiceType::class, [
                'required' => false,
                'placeholder' => false,
                'choices' => [
                    $Parsedown->line(
                        '<span>Random assignment</span>
                        <span>Your study used random assignment to place participants in conditions</span>'
                    ) => 'Random assignment',
                    $Parsedown->line(
                        '<span>Non-random assignment</span>
                        <span>Your study did not use random assignment to place participants in conditions</span>'
                    ) => 'Non-random assignment',
                    $Parsedown->line(
                        '<span>Clinical trial</span>
                        <span>Your study qualifies as a clinical trial (randomized trial, randomized controlled trial)</span>'
                    ) => 'Clinical trial',
                ],
                'expanded' => true,
                'label' => 'Further describe the <span class="font-semibold">experimental design</span> of your study',
                'label_attr' => ['class' => 'MetaData-Label px-0'],
                'label_html' => true,
                'attr' => [
                    'class' => 'p-1',
                ],
                'choice_attr' => function () {
                    return [
                        'class' => 'RadioButton-Input',
                    ];
                }
            ])
            ->add("nonExperimentalDetails", ChoiceType::class, [
                'required' => false,
                'placeholder' => false,
                'choices' => [
                    $Parsedown->line(
                        '<span>Observational study</span><span>You observed people\'s behavior without experimental manipulation</span>'
                    ) => 'Observational study',
                    $Parsedown->line(
                        '<span>Survey research</span><span>You collected information from a sample of individuals through their responses to questions</span>'
                    ) => 'Survey research',
                    $Parsedown->line(
                        '<span>Correlational research</span><span>You measured two variables and assessed the statistical relationship between them</span>'
                    ) => 'Correlational research',
                    $Parsedown->line(
                        '<span>Causal-comparative research</span><span>You selected samples from two already-existing populations and investigated cause and effect relationship</span>'
                    ) => 'Causal-comparative research',
                    $Parsedown->line(
                        '<span>Single case</span>
                        <span>Your study was conducted on a single individual (also known as case study or experience report)</span>'
                    ) => 'Single case'
                ],
                'expanded' => true,
                'label' => 'Further describe the <span class="font-semibold">non-experimental design</span> of your study',
                'label_attr' => ['class' => 'MetaData-Label px-0'],
                'label_html' => true,
                'attr' => [
                    'class' => 'p-1',
                ],
                'choice_attr' => function () {
                    return [
                        'class' => 'RadioButton-Input',
                    ];
                }
            ])
            ->add("observationalType", ChoiceType::class, [
                'required' => false,
                'placeholder' => 'Choose an observational type',
                'choices' => [
                    'Cohort study' => 'Cohort study',
                    'Case-control study' => 'Case-control study',
                    'Cross-sectional study' => 'Cross-sectional study',
                ],
                'label' => 'Optionally define the observational type of your study',
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
                    $Parsedown->line(
                        '<span>Independent measures / between-subjects design</span><span>Different participants were used in each condition of the independent variable</span>'
                    ) => 'Independent measures / between-subjects design',
                    $Parsedown->line(
                        '<span>Repeated measures / within-subjects design</span><span>The same participants took part in each condition of the independent variable</span>'
                    ) => 'Repeated measures / within-subjects design',
                    $Parsedown->line(
                        '<span>Matched pairs design</span><span>Each condition used different participants, but they were matched in terms of important characteristics</span>'
                    ) => 'Matched pairs design'
                ],
                'expanded' => true,
                'label' => 'How were participants allocated to the different conditions?',
                'attr' => [
                    'class' => 'p-1',
                ],
            ])
            ->add(MetaDataDictionary::CONTROL_OPERATIONS, ChoiceType::class, [
                'required' => false,
                'placeholder' => false,
                'choices' => [
                    'None' => 'None',
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
                'label' => 'If other, please specify',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MethodMetaDataGroup::class,
        ]);
    }
}
