<?php

namespace App\Questionnaire\Forms;

use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Model\Study\BasicInformationMetaDataGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\InlinesOnly\InlinesOnlyExtension;
use League\CommonMark\MarkdownConverter;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BasicInformationType extends AbstractType
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $environment = new Environment();
        $environment->addExtension(new InlinesOnlyExtension());
        $commonMark = new MarkdownConverter($environment);

        $builder
            ->add(MetaDataDictionary::TITLE, TextareaType::class, [
                'required' => false,
                'label' => 'input.title.label',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                    'rows' => '3'
                ]
            ])
            ->add(MetaDataDictionary::DESCRIPTION, TextareaType::class, [
                'required' => false,
                'label' => 'input.description.label',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-TextInput',
                    'rows' => '14'
                ]
            ])
            ->add(MetaDataDictionary::RELATED_PUBS, CollectionType::class, [
                'required' => false,
                'entry_type' => TextareaType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'class' => 'w-full',
                        'rows' => '4'
                    ]
                ],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => $commonMark->convertToHtml($this->translator->trans(
                    'input.relatedPubs.label'
                ))->getContent(),
                'label_attr' => ['class' => 'MetaData-Label'],
                'label_html' => true,
                'attr' => [
                    'class' => 'MetaData-Widget MetaData-Widget_collection',
                ]
            ])
            ->add(MetaDataDictionary::CREATORS, CollectionType::class, [
                'entry_type' => CreatorType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'x-data' => '',
                        'x-on:keydown.enter.prevent' => '',
                        'class' => 'Creator-Details'
                    ]
                ],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => 'input.creator.label',
                'label_attr' => ['class' => 'MetaData-Label'],
                'attr' => [
                    'class' => 'MetaData-Widget MetaData-Widget_collection',
                ]
            ])
            ->add('saveAndNext', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BasicInformationMetaDataGroup::class,
        ]);
    }
}
