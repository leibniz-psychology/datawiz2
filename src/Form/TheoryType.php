<?php

namespace App\Form;

use App\Entity\Constant\MetaDataDictionary;
use App\Entity\Study\TheoryMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
                    'rows' => '6',
                ],
            ])
            ->add(MetaDataDictionary::HYPOTHESIS, TextareaType::class, [
                'required' => false,
                'label' => 'input.hypothesis.label',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                    'rows' => '6',
                ],
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
        $resolver->setDefaults(['data_class' => TheoryMetaDataGroup::class]);
    }
}
