<?php

declare(strict_types=1);

namespace App\Form\DataManagementPlan;

use App\Entity\DataManagementPlan\DmpResearchData;
use App\Enum\DataManagementPlan\Dictionary\DmpResearchDataDictionary;
use App\Enum\DataManagementPlan\ExistingDataReuse;
use App\Enum\DataManagementPlan\ResearchMethod;
use App\Enum\Study\CollectionMode;
use App\Enum\Study\ResearchDesign;
use App\Enum\YesNo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DmpResearchDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(DmpResearchDataDictionary::EXISTING_DATA_REUSE->value, EnumType::class, [
                'required' => false,
                'label' => DmpResearchDataDictionary::EXISTING_DATA_REUSE->label(),
                'class' => ExistingDataReuse::class,
                'placeholder' => false,
                'choice_label' => fn (ExistingDataReuse $unit) => $unit->label(),
                'choice_translation_domain' => 'enums',
                'expanded' => true,
            ])
            ->add(DmpResearchDataDictionary::EXISTING_DATA_CITATION->value, TextareaType::class, [
                'required' => false,
                'label' => DmpResearchDataDictionary::EXISTING_DATA_CITATION->label(),
                'attr' => [
                    'rows' => '5',
                    'placeholder' => DmpResearchDataDictionary::EXISTING_DATA_CITATION->placeholder(),
                ],
            ])
            ->add(DmpResearchDataDictionary::EXISTING_DATA_RELEVANCE->value, TextareaType::class, [
                'required' => false,
                'label' => DmpResearchDataDictionary::EXISTING_DATA_RELEVANCE->label(),
                'help' => DmpResearchDataDictionary::EXISTING_DATA_RELEVANCE->help(),
                'attr' => [
                    'rows' => '5',
                    'placeholder' => DmpResearchDataDictionary::EXISTING_DATA_RELEVANCE->placeholder(),
                ],
            ])
            ->add(DmpResearchDataDictionary::EXISTING_DATA_INTEGRATION->value, TextareaType::class, [
                'required' => false,
                'label' => DmpResearchDataDictionary::EXISTING_DATA_INTEGRATION->label(),
                'help' => DmpResearchDataDictionary::EXISTING_DATA_INTEGRATION->help(),
                'attr' => [
                    'rows' => '5',
                    'placeholder' => DmpResearchDataDictionary::EXISTING_DATA_INTEGRATION->placeholder(),
                ],
            ])
            ->add(DmpResearchDataDictionary::RESEARCH_METHOD->value, EnumType::class, [
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'label' => DmpResearchDataDictionary::RESEARCH_METHOD->label(),
                'class' => ResearchMethod::class,
                'placeholder' => false,
                'choice_label' => fn (ResearchMethod $method) => $method->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpResearchDataDictionary::RESEARCH_METHOD_OTHER->value, TextareaType::class, [
                'required' => false,
                'label' => DmpResearchDataDictionary::RESEARCH_METHOD_OTHER->label(),
                'help' => DmpResearchDataDictionary::RESEARCH_METHOD_OTHER->help(),
                'attr' => [
                    'rows' => '5',
                    'placeholder' => DmpResearchDataDictionary::RESEARCH_METHOD_OTHER->placeholder(),
                ],
            ])
            ->add(DmpResearchDataDictionary::DATA_COLLECTION_REPRODUCIBILITY->value, TextareaType::class, [
                'required' => false,
                'label' => DmpResearchDataDictionary::DATA_COLLECTION_REPRODUCIBILITY->label(),
                'attr' => [
                    'rows' => '5',
                    'placeholder' => DmpResearchDataDictionary::DATA_COLLECTION_REPRODUCIBILITY->placeholder(),
                ],
            ])
            ->add(DmpResearchDataDictionary::COLLECTION_MODE->value, EnumType::class, [
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'label' => DmpResearchDataDictionary::COLLECTION_MODE->label(),
                'class' => CollectionMode::class,
                'placeholder' => false,
                'choice_label' => fn (CollectionMode $mode) => $mode->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpResearchDataDictionary::COLLECTION_APPARATUS->value, TextareaType::class, [
                'required' => false,
                'label' => DmpResearchDataDictionary::COLLECTION_APPARATUS->label(),
                'attr' => [
                    'rows' => '5',
                    'placeholder' => DmpResearchDataDictionary::COLLECTION_APPARATUS->placeholder(),
                ],
            ])
            ->add(DmpResearchDataDictionary::COLLECTION_MODE_OTHER->value, TextareaType::class, [
                'required' => false,
                'label' => DmpResearchDataDictionary::COLLECTION_MODE_OTHER->label(),
                'attr' => [
                    'rows' => '5',
                    'placeholder' => DmpResearchDataDictionary::COLLECTION_MODE_OTHER->placeholder(),
                ],
            ])
            ->add(DmpResearchDataDictionary::RESEARCH_DESIGN->value, EnumType::class, [
                'required' => false,
                'label' => DmpResearchDataDictionary::RESEARCH_DESIGN->label(),
                'class' => ResearchDesign::class,
                'placeholder' => false,
                'choice_label' => fn (ResearchDesign $mode) => $mode->label(),
                'choice_translation_domain' => 'enums',
                'expanded' => true,
            ])
            ->add(DmpResearchDataDictionary::DATA_COLLECTOR_TRAINING->value, TextareaType::class, [
                'required' => false,
                'label' => DmpResearchDataDictionary::DATA_COLLECTOR_TRAINING->label(),
                'attr' => [
                    'rows' => '5',
                    'placeholder' => DmpResearchDataDictionary::DATA_COLLECTOR_TRAINING->placeholder(),
                ],
            ])
            ->add(DmpResearchDataDictionary::CONSTRUCTS_MULTIPLE_MEASUREMENT->value, TextareaType::class, [
                'required' => false,
                'label' => DmpResearchDataDictionary::CONSTRUCTS_MULTIPLE_MEASUREMENT->label(),
                'attr' => [
                    'rows' => '5',
                    'placeholder' => DmpResearchDataDictionary::CONSTRUCTS_MULTIPLE_MEASUREMENT->placeholder(),
                ],
            ])
            ->add(DmpResearchDataDictionary::QUALITY_ASSURANCE_OTHER->value, TextareaType::class, [
                'required' => false,
                'label' => DmpResearchDataDictionary::QUALITY_ASSURANCE_OTHER->label(),
                'help' => DmpResearchDataDictionary::QUALITY_ASSURANCE_OTHER->help(),
                'attr' => [
                    'rows' => '5',
                    'placeholder' => DmpResearchDataDictionary::QUALITY_ASSURANCE_OTHER->placeholder(),
                ],
            ])
            ->add(DmpResearchDataDictionary::FILE_FORMATS->value, TextareaType::class, [
                'required' => false,
                'label' => DmpResearchDataDictionary::FILE_FORMATS->label(),
                'attr' => [
                    'rows' => '5',
                    'placeholder' => DmpResearchDataDictionary::FILE_FORMATS->placeholder(),
                ],
            ])
            ->add(DmpResearchDataDictionary::DATA_PRESERVATION_WORKING_COPY->value, EnumType::class, [
                'required' => false,
                'label' => DmpResearchDataDictionary::DATA_PRESERVATION_WORKING_COPY->label(),
                'class' => YesNo::class,
                'placeholder' => DmpResearchDataDictionary::DATA_PRESERVATION_WORKING_COPY->placeholder(),
                'choice_label' => fn (YesNo $yesNo) => $yesNo->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpResearchDataDictionary::DATA_PRESERVATION_GOOD_SCIENTIFIC_PRACTICE_PROOF->value, EnumType::class, [
                'required' => false,
                'label' => DmpResearchDataDictionary::DATA_PRESERVATION_GOOD_SCIENTIFIC_PRACTICE_PROOF->label(),
                'class' => YesNo::class,
                'placeholder' => DmpResearchDataDictionary::DATA_PRESERVATION_GOOD_SCIENTIFIC_PRACTICE_PROOF->placeholder(),
                'choice_label' => fn (YesNo $yesNo) => $yesNo->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpResearchDataDictionary::DATA_PRESERVATION_REPRODUCIBILITY->value, EnumType::class, [
                'required' => false,
                'label' => DmpResearchDataDictionary::DATA_PRESERVATION_REPRODUCIBILITY->label(),
                'class' => YesNo::class,
                'placeholder' => DmpResearchDataDictionary::DATA_PRESERVATION_REPRODUCIBILITY->placeholder(),
                'choice_label' => fn (YesNo $yesNo) => $yesNo->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpResearchDataDictionary::DATA_PRESERVATION_LEGAL_OBLIGATIONS->value, EnumType::class, [
                'required' => false,
                'label' => DmpResearchDataDictionary::DATA_PRESERVATION_LEGAL_OBLIGATIONS->label(),
                'class' => YesNo::class,
                'placeholder' => DmpResearchDataDictionary::DATA_PRESERVATION_LEGAL_OBLIGATIONS->placeholder(),
                'choice_label' => fn (YesNo $yesNo) => $yesNo->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpResearchDataDictionary::DATA_PRESERVATION_BEST_PRACTICE->value, EnumType::class, [
                'required' => false,
                'label' => DmpResearchDataDictionary::DATA_PRESERVATION_BEST_PRACTICE->label(),
                'class' => YesNo::class,
                'placeholder' => DmpResearchDataDictionary::DATA_PRESERVATION_BEST_PRACTICE->placeholder(),
                'choice_label' => fn (YesNo $yesNo) => $yesNo->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpResearchDataDictionary::STORAGE_DURATION->value, TextareaType::class, [
                'required' => false,
                'label' => DmpResearchDataDictionary::STORAGE_DURATION->label(),
                'attr' => [
                    'rows' => '5',
                    'placeholder' => DmpResearchDataDictionary::STORAGE_DURATION->placeholder(),
                ],
            ])
            ->add(DmpResearchDataDictionary::DELETION_PROCEDURES->value, TextareaType::class, [
                'required' => false,
                'label' => DmpResearchDataDictionary::DELETION_PROCEDURES->label(),
                'attr' => [
                    'rows' => '5',
                    'placeholder' => DmpResearchDataDictionary::DELETION_PROCEDURES->placeholder(),
                ],
            ])
            ->add(DmpResearchDataDictionary::DATA_SELECTION->value, EnumType::class, [
                'required' => false,
                'label' => DmpResearchDataDictionary::DATA_SELECTION->label(),
                'class' => YesNo::class,
                'placeholder' => DmpResearchDataDictionary::DATA_SELECTION->placeholder(),
                'choice_label' => fn (YesNo $yesNo) => $yesNo->label(),
                'choice_translation_domain' => 'enums',
            ])
            ->add(DmpResearchDataDictionary::DATA_SELECTION_TIME_POINT->value, TextareaType::class, [
                'required' => false,
                'label' => DmpResearchDataDictionary::DATA_SELECTION_TIME_POINT->label(),
                'attr' => [
                    'rows' => '5',
                    'placeholder' => DmpResearchDataDictionary::DATA_SELECTION_TIME_POINT->placeholder(),
                ],
            ])
            ->add(DmpResearchDataDictionary::DATA_SELECTION_PROCEDURES->value, TextareaType::class, [
                'required' => false,
                'label' => DmpResearchDataDictionary::DATA_SELECTION_PROCEDURES->label(),
                'help' => DmpResearchDataDictionary::DATA_SELECTION_PROCEDURES->help(),
                'attr' => [
                    'rows' => '5',
                    'placeholder' => DmpResearchDataDictionary::DATA_SELECTION_PROCEDURES->placeholder(),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DmpResearchData::class,
            'translation_domain' => 'forms',
        ]);
    }
}
