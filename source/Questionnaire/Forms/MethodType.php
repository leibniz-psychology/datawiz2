<?php

namespace App\Questionnaire\Forms;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Model\Study\MethodMetaDataGroup;
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
                    'Artificial setting' => 'Artificial setting',
                    'Real-life setting' => 'Real-life setting',
                    'Natural setting' => 'Natural setting'
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
            // TODO: Location Textfield was not mapped yet
            ->add(MetaDataDictionary::RESEARCH_DESIGN, ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'Independent measures / between-subjects design' => 'Independent measures / between-subjects design',
                    'Repeated measures / within-subjects design' => 'Repeated measures / within-subjects design',
                    'Matched pairs design' => 'Matched pairs design'
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
            ]);
        // TODO: Others free Textfield is not mapped yet and missing
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MethodMetaDataGroup::class,
        ]);
    }
}
