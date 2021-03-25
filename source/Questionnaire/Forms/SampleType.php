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
                'label' => 'Inclusion criteria',
                'help' => 'State inclusion criteria for participants',
            ])
            ->add(MetaDataDictionary::EXCLUSION_CRITERIA, TextareaType::class, [
                'label' => 'Exclusion criteria',
                'help' => 'State exclusion criteria for participants',
            ])
            ->add(MetaDataDictionary::POPULATION, TextareaType::class, [
                'label' => 'Population',
                'help' => 'Provide information on the group of individuals to which your results can be generalized',
            ])
            ->add(MetaDataDictionary::SAMPLING_METHOD, TextareaType::class, [
                'label' => 'Sampling method',
                'help' => '',
            ])
            ->add(MetaDataDictionary::SAMPLE_SIZE, TextType::class, [
                'label' => 'Sample size',
                'help' => 'Provide the achieved sample size as total number of cases N or as number of cases in subsamples n',
            ])
            ->add(MetaDataDictionary::POWER_ANALYSIS, TextareaType::class, [
                'label' => 'Power analysis (statistical)',
                'help' => 'Provide details of the power analysis used to calculate your sample size ',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SampleMetaDataGroup::class,
        ]);
    }
}
