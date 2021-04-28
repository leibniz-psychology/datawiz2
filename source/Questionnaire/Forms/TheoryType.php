<?php

namespace App\Questionnaire\Forms;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Model\Study\TheoryMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TheoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(MetaDataDictionary::OBJECTIVE, TextareaType::class, [
                'label' => 'Objective',
                'help' => 'Outline the specific steps that you took to achieve your research aim.',
                'label_attr' => ['class' => 'MetaData-Title'],
                'help_attr' => ['class' => 'px-6 pt-1'],
                'attr' => [
                    'class' => 'p-1',
                ],
            ])
            ->add(MetaDataDictionary::HYPOTHESIS, TextareaType::class, [
                'label' => 'Hypotheses',
                'help' => 'State the hypotheses examined, indicating which were prespecified.',
                'label_attr' => ['class' => 'MetaData-Title'],
                'help_attr' => ['class' => 'px-6 pt-1'],
                'attr' => [
                    'class' => 'p-1',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TheoryMetaDataGroup::class,
        ]);
    }
}
