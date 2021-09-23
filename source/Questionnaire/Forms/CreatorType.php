<?php

namespace App\Questionnaire\Forms;

use App\Domain\Model\Study\CreatorMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreatorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('givenName', TextType::class, [
                'required' => false,
                'label' => 'input.creator.name.given',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                ],
            ])
            ->add('familyName', TextType::class, [
                'required' => false,
                'label' => 'input.creator.name.family',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                ],
            ])
            ->add('email', EmailType::class, [
                'required' => false,
                'label' => 'input.creator.email',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                ],
            ])
            ->add('affiliation', TextType::class, [
                'required' => false,
                'label' => 'input.creator.affiliation',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => CreatorMetaDataGroup::class]);
    }
}
