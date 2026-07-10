<?php

namespace App\Form\Study;

use App\Entity\Study\MeasureMetaDataGroup;
use App\Enum\Study\CollectionMode;
use App\Enum\Study\DataDigitization;
use App\Enum\Study\Dictionary\MeasureDictionary;
use App\Enum\Study\RecordType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(MeasureDictionary::DATA_COLLECTION_START->value, DateType::class, [
                'required' => false,
                'label' => MeasureDictionary::DATA_COLLECTION_START->label(),
                'input' => 'date_point',
                'widget' => 'single_text',
            ])
            ->add(MeasureDictionary::DATA_COLLECTION_END->value, DateType::class, [
                'required' => false,
                'label' => MeasureDictionary::DATA_COLLECTION_END->label(),
                'input' => 'date_point',
                'widget' => 'single_text',
            ])
            ->add(MeasureDictionary::COLLECTION_MODE->value, EnumType::class, [
                'required' => false,
                'placeholder' => false,
                'class' => CollectionMode::class,
                'expanded' => true,
                'multiple' => true,
                'label' => MeasureDictionary::COLLECTION_MODE->label(),
                'choice_label' => fn (CollectionMode $details) => $details->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(MeasureDictionary::COLLECTION_INVESTIGATOR_PRESENCE->value, TextareaType::class, [
                'required' => false,
                'label' => MeasureDictionary::COLLECTION_INVESTIGATOR_PRESENCE->label(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(MeasureDictionary::APPARATUS->value, TextareaType::class, [
                'required' => false,
                'label' => MeasureDictionary::APPARATUS->label(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(MeasureDictionary::COLLECTION_MODE_OTHER_DESCRIPTION->value, TextareaType::class, [
                'required' => false,
                'label' => MeasureDictionary::COLLECTION_MODE_OTHER_DESCRIPTION->label(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(MeasureDictionary::ORIGINAL_RECORD_TYPE->value, EnumType::class, [
                'required' => false,
                'placeholder' => false,
                'class' => RecordType::class,
                'expanded' => true,
                'multiple' => true,
                'label' => MeasureDictionary::ORIGINAL_RECORD_TYPE->label(),
                'choice_label' => fn (RecordType $recordType) => $recordType->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(MeasureDictionary::ORIGINAL_RECORD_TYPE_OTHER_DESCRIPTION->value, TextareaType::class, [
                'required' => false,
                'label' => MeasureDictionary::ORIGINAL_RECORD_TYPE_OTHER_DESCRIPTION->label(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(MeasureDictionary::RAW_DATA_DIGITIZATION->value, EnumType::class, [
                'required' => false,
                'placeholder' => false,
                'class' => DataDigitization::class,
                'expanded' => true,
                'label' => MeasureDictionary::RAW_DATA_DIGITIZATION->label(),
                'choice_label' => fn (DataDigitization $dataDigitization) => $dataDigitization->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(MeasureDictionary::RAW_DATA_DIGITIZATION_DESCRIPTION->value, TextareaType::class, [
                'required' => false,
                'label' => MeasureDictionary::RAW_DATA_DIGITIZATION_DESCRIPTION->label(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(MeasureDictionary::SPECIAL_CIRCUMSTANCES->value, TextareaType::class, [
                'required' => false,
                'label' => MeasureDictionary::SPECIAL_CIRCUMSTANCES->label(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(MeasureDictionary::RAW_DATA_TRANSFORMATION->value, TextareaType::class, [
                'required' => false,
                'label' => MeasureDictionary::RAW_DATA_TRANSFORMATION->label(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(MeasureDictionary::QUALITY_INDICATORS->value, TextareaType::class, [
                'required' => false,
                'label' => MeasureDictionary::QUALITY_INDICATORS->label(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
            ->add(MeasureDictionary::LIMITATIONS->value, TextareaType::class, [
                'required' => false,
                'label' => MeasureDictionary::LIMITATIONS->label(),
                'attr' => [
                    'rows' => '3',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MeasureMetaDataGroup::class,
            'translation_domain' => 'forms',
        ]);
    }
}
