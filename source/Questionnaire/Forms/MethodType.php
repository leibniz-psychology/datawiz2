<?php

namespace App\Questionnaire\Forms;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Model\Study\MethodMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MethodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(MetaDataDictionary::SETTING, TextareaType::class, [
                'label' => 'Setting',
                'help' => '',
                'label_attr' => ['class' => 'MetaData-Title'],
                'help_attr' => ['class' => 'px-6 pt-1'],
                'attr' => [
                    'class' => 'p-1',
                ]
            ])
            ->add(MetaDataDictionary::RESEARCH_DESIGN, TextareaType::class, [
                'label' => 'Research design',
                'help' => '',
                'label_attr' => ['class' => 'MetaData-Title'],
                'help_attr' => ['class' => 'px-6 pt-1'],
                'attr' => [
                    'class' => 'p-1',
                ]
            ])
            ->add(MetaDataDictionary::MANIPULATIONS, TextareaType::class, [
                'label' => 'Experimental manipulation(s), treatments, or interventions',
                'help' => 'Provide details of your experimental manipulation(s) including a summary of the instructions. Clearly define your variables (treatments).',
                'label_attr' => ['class' => 'MetaData-Title'],
                'help_attr' => ['class' => 'px-6 pt-1'],
                'attr' => [
                    'class' => 'p-1',
                ]
            ])
            ->add(MetaDataDictionary::ASSIGNMENT, TextareaType::class, [
                'label' => 'Assignment of participants to condition(s)/manipulation(s)',
                'help' => 'How did you place participants in conditions? Select random or non-random',
                'label_attr' => ['class' => 'MetaData-Title'],
                'help_attr' => ['class' => 'px-6 pt-1'],
                'attr' => [
                    'class' => 'p-1',
                ]
            ])
            ->add(MetaDataDictionary::EXPERIMENTAL_DESIGN, TextareaType::class, [
                'label' => 'Experimenttal?',
                'help' => '',
                'label_attr' => ['class' => 'MetaData-Title'],
                'help_attr' => ['class' => 'px-6 pt-1'],
                'attr' => [
                    'class' => 'p-1',
                ]
            ])
            ->add(MetaDataDictionary::CONTROL_OPERATIONS, TextareaType::class, [
                'label' => 'Control Operations?',
                'help' => '',
                'label_attr' => ['class' => 'MetaData-Title'],
                'help_attr' => ['class' => 'px-6 pt-1'],
                'attr' => [
                    'class' => 'p-1',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MethodMetaDataGroup::class,
        ]);
    }
}
