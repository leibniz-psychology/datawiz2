<?php

namespace App\Questionnaire\Forms;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Model\Study\SampleMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Parsedown;

class SampleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $Parsedown = new Parsedown();

        $builder
            ->add("participants", TextareaType::class, [
                'required' => false,
                'label' => 'Describe participants, specifying their pertinent characteristics for this study',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                ]
            ])
            ->add(MetaDataDictionary::INCLUSION_CRITERIA, CollectionType::class, [
                'required' => false,
                'entry_type' => TextType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'State inclusion criteria for participants',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-Widget MetaData-Widget_collection',
                    'data-entry-add-label' => 'another creator +',
                    'data-entry-add-class' => 'MetaData-AddButton',
                    'data-entry-remove-class' => 'MetaData-RemoveButton'
                ]
            ])
            ->add(MetaDataDictionary::EXCLUSION_CRITERIA, CollectionType::class, [
                'required' => false,
                'entry_type' => TextType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'State exclusion criteria for participants',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-Widget MetaData-Widget_collection',
                    'data-entry-add-label' => 'another creator +',
                    'data-entry-add-class' => 'MetaData-AddButton',
                    'data-entry-remove-class' => 'MetaData-RemoveButton'
                ]
            ])
            ->add(MetaDataDictionary::POPULATION, CollectionType::class, [
                'required' => false,
                'entry_type' => TextType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'Provide information on the group of individuals to which your results can be generalized',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-Widget MetaData-Widget_collection',
                    'data-entry-add-label' => 'another creator +',
                    'data-entry-add-class' => 'MetaData-AddButton',
                    'data-entry-remove-class' => 'MetaData-RemoveButton'
                ]
            ])
            ->add(MetaDataDictionary::SAMPLING_METHOD, ChoiceType::class, [
                'required' => false,
                'expanded' => true,
                'placeholder' => false,
                'label' => 'Choose your sampling method',
                'choices' => [
                    $Parsedown->line(
                        '<span>Convenience sampling (accidental sampling, opportunity sampling)</span><span>Your individuals (observations, cases) were chosen non-randomly because they were easily available</span>'
                    ) => 'Convenience sampling (accidental sampling, opportunity sampling)',
                    $Parsedown->line(
                        '<span>Random sampling</span><span>Your individuals (observations, cases) were chosen randomly and entirely by chance</span>'
                    ) => 'Random sampling (probability sampling)',
                    $Parsedown->line(
                        '<span>Systematic sampling (quasirandom sampling)</span><span>Your individuals (observations, cases) were chosen randomly with a system</span>'
                    ) => 'Systematic sampling (quasirandom sampling)',
                    $Parsedown->line(
                        '<span>Stratified sampling</span><span>Your individuals (observations, cases) were chosen randomly from subgroups (strata)</span>'
                    ) => 'Stratified sampling',
                    $Parsedown->line(
                        '<span>Quota sampling</span><span>Your individuals (observations, cases) were chosen non-randomly on the basis of a specific plan</span>'
                    ) => 'Quota sampling',
                    'Other' => 'Other',
                ],
                'label_attr' => ['class' => 'MetaData-Label'],
                'label_html' => true,
                'attr' => [
                    'class' => 'p-1',
                ],
                'choice_attr' => function () {
                    return ['class' => 'RadioButton-Input'];
                }
            ])
            ->add("otherSamplingMethod", TextareaType::class, [
                'required' => false,
                'label' => 'If other, please describe your sampling method (see help for a list of methods)',
            ])
            ->add(MetaDataDictionary::SAMPLE_SIZE, TextareaType::class, [
                'required' => false,
                'label' => 'Provide the achieved sample size as total number of cases N or as number of cases in subsamples n',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                ]
            ])
            ->add(MetaDataDictionary::POWER_ANALYSIS, TextareaType::class, [
                'required' => false,
                'label' => 'Provide details of the power analysis used to calculate your sample size ',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SampleMetaDataGroup::class,
        ]);
    }
}
