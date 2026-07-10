<?php

namespace App\Form\Study;

use App\Entity\Study\MethodConstruct;
use App\Enum\Study\ConstructFunction;
use App\Enum\Study\Dictionary\MethodConstructDictionary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MethodConstructType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(MethodConstructDictionary::NAME->value, TextType::class, [
                'required' => false,
                'label' => MethodConstructDictionary::NAME->label(),
            ])
            ->add(MethodConstructDictionary::CONSTRUCT_FUNCTION->value, EnumType::class, [
                'required' => false,
                'placeholder' => MethodConstructDictionary::CONSTRUCT_FUNCTION->placeholder(),
                'class' => ConstructFunction::class,
                'label' => MethodConstructDictionary::CONSTRUCT_FUNCTION->label(),
                'choice_label' => fn (ConstructFunction $function) => $function->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(MethodConstructDictionary::OTHER_FUNCTION_DESCRIPTION->value, TextareaType::class, [
                'required' => false,
                'label' => MethodConstructDictionary::OTHER_FUNCTION_DESCRIPTION->label(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MethodConstruct::class,
            'translation_domain' => 'forms',
        ]);
    }
}
