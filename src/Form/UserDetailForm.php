<?php

namespace App\Form;

use App\Entity\Administration\DataWizUser;
use App\Entity\Constant\UserRoles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserDetailForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['allow_edit_roles']) {
            $builder->add('roles', ChoiceType::class, [
                'label' => 'title.admin.dashboard.user.roles',
                'choices' => UserRoles::getAll(),
                'required' => true,
                'expanded' => false,
                'multiple' => false,
                'choice_label' => fn ($choice) => 'roles.'.$choice,
                'row_attr' => [
                    'class' => 'pt-8',
                ],
                'label_attr' => [
                    'class' => 'pr-6',
                ],
                'attr' => [
                    'class' => 'MetaData-SelectInput',
                ],
            ]);

            $builder->get('roles')
                ->addModelTransformer(
                    new CallbackTransformer(
                        fn ($rolesArray) => count($rolesArray) ? $rolesArray[0] : null,
                        fn ($rolesString) => array_filter([$rolesString])
                    )
                );
        }

        $builder
            ->add(
                'email',
                TextType::class,
                [
                    'label' => 'input.creator.email',
                    'attr' => [
                        'class' => 'MetaData-TextInput',
                        'rows' => '3',
                        'readonly' => true,
                    ],
                    'row_attr' => [
                        'class' => 'pt-6',
                    ],
                ]
            )
            ->add(
                'firstname',
                TextType::class,
                [
                    'label' => 'input.creator.name.given',
                    'attr' => [
                        'class' => 'MetaData-TextInput',
                        'rows' => '3',
                        'readonly' => true,
                    ],
                ]
            )->add(
                'lastname',
                TextType::class,
                [
                    'label' => 'input.creator.name.family',
                    'attr' => [
                        'class' => 'MetaData-TextInput',
                        'rows' => '3',
                        'readonly' => true,
                    ],
                    'row_attr' => [
                        'class' => 'pt-6',
                    ],
                ]
            )
            ->add(
                'save',
                SubmitType::class,
                [
                    'attr' => [
                        'class' => 'MetaData-SubmitButton Button Button_primary Button_primary_act Button_standalone',
                    ],
                    'label' => 'generic.save-changes',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => DataWizUser::class,
                'csrf_protection' => true,
                'csrf_field_name' => '_token',
                'csrf_token_id' => 'user_profile_form',
                'allow_edit_roles' => false,
            ]
        );
        $resolver->setAllowedTypes('allow_edit_roles', 'bool');
    }
}
