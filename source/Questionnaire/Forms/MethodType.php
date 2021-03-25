<?php

namespace App\Questionnaire\Forms;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Model\Study\MethodMetaDataGroup;
use App\Domain\Model\Study\ResearchMetaDataGroup;
use SebastianBergmann\CodeCoverage\Report\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MethodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(MetaDataDictionary::SETTING, TextareaType::class, [
                'label'=>'Setting',
                'help'=>''

            ])
            ->add(MetaDataDictionary::RESEARCH_DESIGN, TextareaType::class, [
                'label'=>'Research design',
                'help'=>''
            ])
            ->add(MetaDataDictionary::MANIPULATIONS, TextareaType::class, [
                'label'=>'Experimental manipulation(s), treatments, or interventions',
                'help'=>'Provide details of your experimental manipulation(s) including a summary of the instructions. Clearly define your variables (treatments).'
            ])
            ->add(MetaDataDictionary::ASSIGNMENT, TextareaType::class, [
                'label'=>'Assignment of participants to condition(s)/manipulation(s)',
                'help'=>'How did you place participants in conditions? Select random or non-random'
            ])
            ->add(MetaDataDictionary::EXPERIMENTAL_DESIGN, TextareaType::class, [
                'label'=>'Experimenttal?',
                'help'=>''
            ])
            ->add(MetaDataDictionary::CONTROL_OPERATIONS, TextareaType::class, [
                'label'=>'Control Operations?',
                'help'=>''
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
