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
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\InlinesOnly\InlinesOnlyExtension;
use League\CommonMark\MarkdownConverter;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SampleType extends AbstractType
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $environment = new Environment();
        $environment->addExtension(new InlinesOnlyExtension());
        $commonMark = new MarkdownConverter($environment);

        $builder
            ->add("participants", TextareaType::class, [
                'required' => false,
                'label' => 'input.participants.label',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                    'rows' => '3'
                ],
            ])
            ->add(MetaDataDictionary::POPULATION, CollectionType::class, [
                'required' => false,
                'entry_type' => TextType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'x-data' => '',
                        'x-on:keydown.enter.prevent' => '',
                        'class' => 'w-full'
                    ],
                ],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'input.population.label',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => ['class' => 'MetaData-Widget MetaData-Widget_collection'],
            ])
            ->add(MetaDataDictionary::INCLUSION_CRITERIA, CollectionType::class, [
                'required' => false,
                'entry_type' => TextType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'x-data' => '',
                        'x-on:keydown.enter.prevent' => '',
                        'class' => 'w-full'
                    ],
                ],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'input.inclusion.label',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => ['class' => 'MetaData-Widget MetaData-Widget_collection'],
            ])
            ->add(MetaDataDictionary::EXCLUSION_CRITERIA, CollectionType::class, [
                'required' => false,
                'entry_type' => TextType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'x-data' => '',
                        'x-on:keydown.enter.prevent' => '',
                        'class' => 'w-full'
                    ],
                ],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'input.exclusion.label',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => ['class' => 'MetaData-Widget MetaData-Widget_collection'],
            ])
            ->add(MetaDataDictionary::SAMPLING_METHOD, ChoiceType::class, [
                'required' => false,
                'expanded' => true,
                'placeholder' => false,
                'label' => 'input.sampling.label',
                'choices' => [
                    $commonMark->convertToHtml($this->translator->trans('input.sampling.choices.convenience'))->getContent() => 'Convenience sampling (accidental sampling, opportunity sampling)',
                    $commonMark->convertToHtml($this->translator->trans('input.sampling.choices.random'))->getContent() => 'Random sampling (probability sampling)',
                    $commonMark->convertToHtml($this->translator->trans('input.sampling.choices.systematic'))->getContent() => 'Systematic sampling (quasirandom sampling)',
                    $commonMark->convertToHtml($this->translator->trans('input.sampling.choices.stratified'))->getContent() => 'Stratified sampling',
                    $commonMark->convertToHtml($this->translator->trans('input.sampling.choices.quota'))->getContent() => 'Quota sampling',
                    'input.sampling.choices.other' => 'Other',
                ],
                'label_attr' => ['class' => 'MetaData-Label'],
                'label_html' => true,
                'attr' => ['class' => 'p-1'],
                'choice_attr' => function () {
                    return ['class' => 'RadioButton-Input'];
                },
            ])
            ->add("otherSamplingMethod", TextareaType::class, [
                'required' => false,
                'label' => 'input.sampling.other.label',
            ])
            ->add(MetaDataDictionary::SAMPLE_SIZE, TextareaType::class, [
                'required' => false,
                'label' => 'input.sample-size.label',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => ['class' => 'MetaData-TextInput'],
            ])
            ->add(MetaDataDictionary::POWER_ANALYSIS, TextareaType::class, [
                'required' => false,
                'label' => 'input.power-analysis.label',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => ['class' => 'MetaData-TextInput'],
            ])
            ->add('saveAndPrevious', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => SampleMetaDataGroup::class]);
    }
}
