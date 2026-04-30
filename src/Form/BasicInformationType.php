<?php

namespace App\Form;

use App\Entity\Study\BasicInformationMetaDataGroup;
use App\Enum\Study\DataStatus;
use App\Enum\Study\Dictionary\BasicInformationDictionary;
use App\Enum\Study\StudyRelation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BasicInformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(BasicInformationDictionary::TITLE->value, TextareaType::class, [
                'required' => false,
                'label' => BasicInformationDictionary::TITLE->label(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(BasicInformationDictionary::TITLE_TRANSLATED->value, TextareaType::class, [
                'required' => false,
                'label' => BasicInformationDictionary::TITLE_TRANSLATED->label(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(BasicInformationDictionary::STUDY_ID->value, TextType::class, [
                'required' => false,
                'label' => BasicInformationDictionary::STUDY_ID->label(),
            ])
            ->add(BasicInformationDictionary::DESCRIPTION->value, TextareaType::class, [
                'required' => false,
                'label' => BasicInformationDictionary::DESCRIPTION->label(),
                'attr' => [
                    'rows' => '14',
                ],
            ])
            ->add(BasicInformationDictionary::DESCRIPTION_TRANSLATED->value, TextareaType::class, [
                'required' => false,
                'label' => BasicInformationDictionary::DESCRIPTION_TRANSLATED->label(),
                'attr' => [
                    'rows' => '14',
                ],
            ])
            ->add(BasicInformationDictionary::DATA_STATUS->value, EnumType::class, [
                'required' => false,
                'label' => BasicInformationDictionary::DATA_STATUS->label(),
                'class' => DataStatus::class,
                'expanded' => true,
                'placeholder' => false,
                'choice_label' => fn (DataStatus $status) => $status->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(BasicInformationDictionary::REUSE_POTENTIAL->value, TextareaType::class, [
                'required' => false,
                'label' => BasicInformationDictionary::REUSE_POTENTIAL->label(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(BasicInformationDictionary::STUDY_RELATION->value, EnumType::class, [
                'required' => false,
                'label' => BasicInformationDictionary::STUDY_RELATION->label(),
                'class' => StudyRelation::class,
                'expanded' => true,
                'placeholder' => false,
                'choice_label' => fn (StudyRelation $relation) => $relation->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(BasicInformationDictionary::STUDY_RELATION_OTHER_DESCRIPTION->value, TextareaType::class, [
                'required' => false,
                'label' => BasicInformationDictionary::STUDY_RELATION_OTHER_DESCRIPTION->label(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(BasicInformationDictionary::USED_SOFTWARES->value, CollectionType::class, [
                'required' => false,
                'entry_type' => TextareaType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'rows' => '4',
                    ],
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'label' => BasicInformationDictionary::USED_SOFTWARES->label(),
                'help' => BasicInformationDictionary::USED_SOFTWARES->help(),
            ])
            ->add(BasicInformationDictionary::RELATED_PUBLICATIONS->value, CollectionType::class, [
                'required' => false,
                'entry_type' => TextareaType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'rows' => '4',
                    ],
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'label' => BasicInformationDictionary::RELATED_PUBLICATIONS->label(),
                'help' => BasicInformationDictionary::RELATED_PUBLICATIONS->help(),
            ])
            ->add(BasicInformationDictionary::CONFLICTS_OF_INTEREST->value, CollectionType::class, [
                'required' => false,
                'entry_type' => TextareaType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'rows' => '4',
                    ],
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'label' => BasicInformationDictionary::CONFLICTS_OF_INTEREST->label(),
                'help' => BasicInformationDictionary::CONFLICTS_OF_INTEREST->help(),
            ])
            ->add(BasicInformationDictionary::CREATORS->value, CollectionType::class, [
                'entry_type' => CreatorType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => BasicInformationDictionary::CREATORS->label(),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => BasicInformationMetaDataGroup::class,
                'translation_domain' => 'forms',
            ]
        );
    }
}
