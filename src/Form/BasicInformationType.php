<?php

namespace App\Form;

use App\Entity\Constant\MetaDataDictionary;
use App\Entity\Study\BasicInformationMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BasicInformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(MetaDataDictionary::TITLE, TextareaType::class, [
                'required' => false,
                'label' => 'input.title.label',
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(MetaDataDictionary::DESCRIPTION, TextareaType::class, [
                'required' => false,
                'label' => 'input.description.label',
                'attr' => [
                    'rows' => '14',
                ],
            ])
            ->add(MetaDataDictionary::RELATED_PUBS, CollectionType::class, [
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
                'label' => 'input.relatedPubs.label',
                'label_html' => true,
            ])
            ->add(MetaDataDictionary::CREATORS, CollectionType::class, [
                'entry_type' => CreatorType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'input.creator.label',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => BasicInformationMetaDataGroup::class,
            ]
        );
    }
}
