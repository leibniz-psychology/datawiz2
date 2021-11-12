<?php

namespace App\Questionnaire\Forms;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Model\Study\MethodMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\InlinesOnly\InlinesOnlyExtension;
use League\CommonMark\MarkdownConverter;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MethodType extends AbstractType
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
            ->add(MetaDataDictionary::SETTING, ChoiceType::class, [
                'required' => false,
                'placeholder' => false,
                'choices' => [
                    $commonMark->convertToHtml($this->translator->trans('input.setting.choices.artificial'))->getContent() => 'Artificial setting',
                    $commonMark->convertToHtml($this->translator->trans('input.setting.choices.rl'))->getContent() => 'Real-life setting',
                    $commonMark->convertToHtml($this->translator->trans('input.setting.choices.natural'))->getContent() => 'Natural setting',
                ],
                'expanded' => true,
                'label' => 'input.setting.label',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => ['class' => 'p-1'],
                'choice_attr' => function () {
                    return ['class' => 'RadioButton-Input'];
                },
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
                    $commonMark->convertToHtml($this->translator->trans('input.design.choices.experimental'))->getContent() => 'Experimental',
                    $commonMark->convertToHtml($this->translator->trans('input.design.choices.non-experimental'))->getContent() => 'Non-experimental',
                ],
                'expanded' => true,
                'label' => 'input.design.label',
                'help' => '',
                'label_attr' => ['class' => 'MetaData-Label'],
                'help_attr' => ['class' => 'px-6 pt-1'],
                'attr' => ['class' => 'p-1'],
                'choice_attr' => function () {
                    return [
                        'class' => 'RadioButton-Input',
                    ];
                },
            ])
            ->add("experimentalDetails", ChoiceType::class, [
                'required' => false,
                'placeholder' => false,
                'choices' => [
                    $commonMark->convertToHtml($this->translator->trans('input.design.details.experimental.choices.random-assignment'))->getContent() => 'Random assignment',
                    $commonMark->convertToHtml($this->translator->trans('input.design.details.experimental.choices.non-random-assignment'))->getContent() => 'Non-random assignment',
                    $commonMark->convertToHtml($this->translator->trans('input.design.details.experimental.choices.clinical-trial'))->getContent() => 'Clinical trial',
                ],
                'expanded' => true,
                'label' => 'input.design.details.experimental.label',
                'label_attr' => ['class' => 'MetaData-Label !pl-0'],
                'label_html' => true,
                'attr' => ['class' => 'p-1'],
                'choice_attr' => function () {
                    return [
                        'class' => 'RadioButton-Input',
                    ];
                },
            ])
            ->add("nonExperimentalDetails", ChoiceType::class, [
                'required' => false,
                'placeholder' => false,
                'choices' => [
                    $commonMark->convertToHtml($this->translator->trans('input.design.details.non-experimental.choices.observational-study'))->getContent() => 'Observational study',
                    $commonMark->convertToHtml($this->translator->trans('input.design.details.non-experimental.choices.survey-research'))->getContent() => 'Survey research',
                    $commonMark->convertToHtml($this->translator->trans('input.design.details.non-experimental.choices.correlational-research'))->getContent() => 'Correlational research',
                    $commonMark->convertToHtml($this->translator->trans('input.design.details.non-experimental.choices.causal-comparative-research'))->getContent() => 'Causal-comparative research',
                    $commonMark->convertToHtml($this->translator->trans('input.design.details.non-experimental.choices.single-case'))->getContent() => 'Single case',
                ],
                'expanded' => true,
                'label' => 'input.design.details.non-experimental.label',
                'label_attr' => ['class' => 'MetaData-Label !pl-0'],
                'label_html' => true,
                'attr' => ['class' => 'p-1'],
                'choice_attr' => function () {
                    return [
                        'class' => 'RadioButton-Input',
                    ];
                },
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
                    $commonMark->convertToHtml($this->translator->trans('input.experimental-design.choices.independent'))->getContent() => 'Independent measures / between-subjects design',
                    $commonMark->convertToHtml($this->translator->trans('input.experimental-design.choices.repeated'))->getContent() => 'Repeated measures / within-subjects design',
                    $commonMark->convertToHtml($this->translator->trans('input.experimental-design.choices.matched'))->getContent() => 'Matched pairs design',
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
                'choice_attr' => function () {
                    return ['class' => 'RadioButton-Input'];
                },
            ])
            ->add("otherControlOperations", TextareaType::class, [
                'required' => false,
                'label' => 'input.control-operations.other.label',
                'attr' => ['class' => 'p-1', 'rows' => '4',],
            ])
            ->add('saveAndPrevious', SubmitType::class)
            ->add('saveAndNext', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => MethodMetaDataGroup::class]);
    }
}
