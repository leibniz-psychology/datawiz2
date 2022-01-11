<?php

namespace App\Questionnaire\Forms;

use App\Domain\Model\Study\CreatorMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
                // 'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                ],
                'row_attr' => ['class' => 'Creator-Detail Creator-Detail_given']
            ])
            ->add('familyName', TextType::class, [
                'required' => false,
                'label' => 'input.creator.name.family',
                // 'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                ],
                'row_attr' => ['class' => 'Creator-Detail Creator-Detail_family']
            ])
            ->add('email', EmailType::class, [
                'required' => false,
                'label' => 'input.creator.email',
                // 'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                ],
                'row_attr' => ['class' => 'Creator-Detail Creator-Detail_email']
            ])
            ->add('orcid', TextType::class, [
                'required' => false,
                'label' => 'input.creator.orcid',
                // 'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                ],
                'row_attr' => ['class' => 'Creator-Detail Creator-Detail_orcid']
            ])
            ->add('affiliation', TextType::class, [
                'required' => false,
                'label' => 'input.creator.affiliation',
                // 'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                ],
                'row_attr' => ['class' => 'Creator-Detail Creator-Detail_affiliation'],
            ])->add('creditRoles', CollectionType::class, [
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => 'input.creator.credit.label',
                'label_html' => true,
                'required' => false,
                'label_attr' => ['class' => 'MetaData-Label !px-4 !mt-0'],
                'attr' => ['class' => 'MetaData-Widget MetaData-Widget_collection'],
                'entry_type'   => ChoiceType::class,
                'delete_empty' => function (String $role = null) {
                    return empty($role);
                },
                'entry_options'  => [
                    'placeholder' => 'input.creator.credit.choices.placeholder',
                    'required' => true,
                    'label' => false,
                    'label_attr' => ['class' => 'MetaData-Label'],
                    'label_html' => true,
                    'attr' => [
                        'class' => 'MetaData-SelectInput w-full',
                    ],
                    'choices' => [
                        'input.creator.credit.choices.conceptualization' => 'Conceptualization',
                        'input.creator.credit.choices.dataCuration' => 'Data curation',
                        'input.creator.credit.choices.formalAnalysis' => 'Formal Analysis',
                        'input.creator.credit.choices.fundingAcquisition' => 'Funding acquisition',
                        'input.creator.credit.choices.investigation' => 'Investigation',
                        'input.creator.credit.choices.methodology' => 'Methodology',
                        'input.creator.credit.choices.projectAdministration' => 'Project administration',
                        'input.creator.credit.choices.resources' => 'Resources',
                        'input.creator.credit.choices.software' => 'Software',
                        'input.creator.credit.choices.supervision' => 'Supervision',
                        'input.creator.credit.choices.validation' => 'Validation',
                        'input.creator.credit.choices.visualization' => 'Visualization',
                        'input.creator.credit.choices.writingOriginalDraft' => 'Writing - original draft',
                        'input.creator.credit.choices.WritingReviewEditing' => 'Writing - review & editing',
                    ],
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => CreatorMetaDataGroup::class]);
    }
}
