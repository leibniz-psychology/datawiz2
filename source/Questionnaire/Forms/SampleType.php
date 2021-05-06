<?php

namespace App\Questionnaire\Forms;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Model\Study\SampleMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SampleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(MetaDataDictionary::INCLUSION_CRITERIA, TextareaType::class, [
                'label' => 'State inclusion criteria for participants',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'p-1',
                ]
            ])
            ->add(MetaDataDictionary::EXCLUSION_CRITERIA, TextareaType::class, [
                'label' => 'State exclusion criteria for participants',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'p-1',
                ]
            ])
            ->add(MetaDataDictionary::POPULATION, TextareaType::class, [
                'label' => 'Provide information on the group of individuals to which your results can be generalized',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'p-1',
                ]
            ])
            ->add(MetaDataDictionary::SAMPLING_METHOD, TextareaType::class, [
                'label' => '',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'p-1',
                ]
            ])
            ->add(MetaDataDictionary::SAMPLE_SIZE, TextType::class, [
                'label' => 'Provide the achieved sample size as total number of cases N or as number of cases in subsamples n',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'p-1',
                ]
            ])
            ->add(MetaDataDictionary::POWER_ANALYSIS, TextareaType::class, [
                'label' => 'Provide details of the power analysis used to calculate your sample size ',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'p-1',
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
