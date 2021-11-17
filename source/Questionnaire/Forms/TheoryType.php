<?php

namespace App\Questionnaire\Forms;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Model\Study\TheoryMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TheoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(MetaDataDictionary::OBJECTIVE, TextareaType::class, [
                'required' => false,
                'label' => 'input.objective.label',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                    'rows' => '6'
                ],
            ])
            ->add(MetaDataDictionary::HYPOTHESIS, TextareaType::class, [
                'required' => false,
                'label' => 'input.hypothesis.label',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                    'rows' => '6'
                ],
            ])
            ->add('saveAndPrevious', SubmitType::class)
            ->add('saveAndNext', SubmitType::class)
            ->add('saveAndIntroduction', SubmitType::class, [
                'attr' => [
                    'class' => 'hidden Button_saveAndIntroduction',
                ]
            ])
            ->add('saveAndDocumentation', SubmitType::class, [
                'attr' => [
                    'class' => 'hidden Button_saveAndDocumentation',
                ]
            ])
            ->add('saveAndTheory', SubmitType::class, [
                'attr' => [
                    'class' => 'hidden Button_saveAndTheory',
                ]
            ])
            ->add('saveAndMethod', SubmitType::class, [
                'attr' => [
                    'class' => 'hidden Button_saveAndMethod',
                ]
            ])
            ->add('saveAndMeasure', SubmitType::class, [
                'attr' => [
                    'class' => 'hidden Button_saveAndMeasure',
                ]
            ])
            ->add('saveAndSample', SubmitType::class, [
                'attr' => [
                    'class' => 'hidden Button_saveAndSample',
                ]
            ])
            ->add('saveAndDatasets', SubmitType::class, [
                'attr' => [
                    'class' => 'hidden Button_saveAndDatasets',
                ]
            ])
            ->add('saveAndMaterials', SubmitType::class, [
                'attr' => [
                    'class' => 'hidden Button_saveAndMaterials',
                ]
            ])
            ->add('saveAndReview', SubmitType::class, [
                'attr' => [
                    'class' => 'hidden Button_saveAndReview',
                ]
            ])
            ->add('saveAndExport', SubmitType::class, [
                'attr' => [
                    'class' => 'hidden Button_saveAndExport',
                ]
            ])
            ->add('saveAndSettings', SubmitType::class, [
                'attr' => [
                    'class' => 'hidden Button_saveAndSettings',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => TheoryMetaDataGroup::class,]);
    }
}
