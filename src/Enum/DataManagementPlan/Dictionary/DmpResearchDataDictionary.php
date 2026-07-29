<?php

declare(strict_types=1);

namespace App\Enum\DataManagementPlan\Dictionary;

use App\Entity\Dto\ReviewDataDto;
use App\Enum\DictionaryEnum;
use App\Enum\DictionaryInterface;
use App\Enum\ErrorType;
use App\Enum\ExtendedEnum;

enum DmpResearchDataDictionary: string implements DictionaryInterface
{
    use ExtendedEnum;
    use DictionaryEnum;

    case EXISTING_DATA_REUSE = 'existingDataReuse';
    case EXISTING_DATA_CITATION = 'existingDataCitation';
    case EXISTING_DATA_RELEVANCE = 'existingDataRelevance';
    case EXISTING_DATA_INTEGRATION = 'existingDataIntegration';
    case RESEARCH_METHOD = 'researchMethod';
    case RESEARCH_METHOD_OTHER = 'researchMethodOtherDescription';
    case DATA_COLLECTION_REPRODUCIBILITY = 'dataCollectionReproducibility';
    case COLLECTION_MODE = 'collectionMode';
    case COLLECTION_APPARATUS = 'collectionApparatus';
    case COLLECTION_MODE_OTHER = 'collectionModeOtherDescription';
    case RESEARCH_DESIGN = 'researchDesign';
    case DATA_COLLECTOR_TRAINING = 'dataCollectorTraining';
    case CONSTRUCTS_MULTIPLE_MEASUREMENT = 'constructsMultipleMeasurement';
    case QUALITY_ASSURANCE_OTHER = 'qualityAssuranceOtherDescription';
    case FILE_FORMATS = 'fileFormats';
    case DATA_PRESERVATION_WORKING_COPY = 'dataPreservationWorkingCopy';
    case DATA_PRESERVATION_GOOD_SCIENTIFIC_PRACTICE_PROOF = 'dataPreservationGoodScientificPracticeProof';
    case DATA_PRESERVATION_REPRODUCIBILITY = 'dataPreservationReproducibility';
    case DATA_PRESERVATION_LEGAL_OBLIGATIONS = 'dataPreservationLegalObligations';
    case DATA_PRESERVATION_BEST_PRACTICE = 'dataPreservationBestPractice';
    case STORAGE_DURATION = 'storageDuration';
    case DELETION_PROCEDURES = 'deletionProcedures';
    case DATA_SELECTION = 'dataSelection';
    case DATA_SELECTION_TIME_POINT = 'dataSelectionTimePoint';
    case DATA_SELECTION_PROCEDURES = 'dataSelectionProcedures';

    public function legend(): string
    {
        return match ($this) {
            self::EXISTING_DATA_REUSE => 'data_management_plan.research_data.existing_data_reuse.legend',
            self::EXISTING_DATA_CITATION => 'data_management_plan.research_data.existing_data_citation.legend',
            self::EXISTING_DATA_RELEVANCE => 'data_management_plan.research_data.existing_data_relevance.legend',
            self::EXISTING_DATA_INTEGRATION => 'data_management_plan.research_data.existing_data_integration.legend',
            self::RESEARCH_METHOD => 'data_management_plan.research_data.research_method.legend',
            self::RESEARCH_METHOD_OTHER => 'data_management_plan.research_data.research_method_other.legend',
            self::DATA_COLLECTION_REPRODUCIBILITY => 'data_management_plan.research_data.data_collection_reproducibility.legend',
            self::COLLECTION_MODE => 'data_management_plan.research_data.collection_mode.legend',
            self::COLLECTION_APPARATUS => 'data_management_plan.research_data.collection_apparatus.legend',
            self::COLLECTION_MODE_OTHER => 'data_management_plan.research_data.collection_mode_other.legend',
            self::RESEARCH_DESIGN => 'data_management_plan.research_data.research_design.legend',
            self::DATA_COLLECTOR_TRAINING => 'data_management_plan.research_data.data_collector_training.legend',
            self::CONSTRUCTS_MULTIPLE_MEASUREMENT => 'data_management_plan.research_data.constructs_multiple_measurement.legend',
            self::QUALITY_ASSURANCE_OTHER => 'data_management_plan.research_data.quality_assurance_other.legend',
            self::FILE_FORMATS => 'data_management_plan.research_data.file_formats.legend',
            self::DATA_PRESERVATION_WORKING_COPY => 'data_management_plan.research_data.data_preservation_working_copy.legend',
            self::DATA_PRESERVATION_GOOD_SCIENTIFIC_PRACTICE_PROOF => 'data_management_plan.research_data.data_preservation_good_scientific_practice_proof.legend',
            self::DATA_PRESERVATION_REPRODUCIBILITY => 'data_management_plan.research_data.data_preservation_reproducibility.legend',
            self::DATA_PRESERVATION_LEGAL_OBLIGATIONS => 'data_management_plan.research_data.data_preservation_legal_obligations.legend',
            self::DATA_PRESERVATION_BEST_PRACTICE => 'data_management_plan.research_data.data_preservation_best_practice.legend',
            self::STORAGE_DURATION => 'data_management_plan.research_data.storage_duration.legend',
            self::DELETION_PROCEDURES => 'data_management_plan.research_data.deletion_procedures.legend',
            self::DATA_SELECTION => 'data_management_plan.research_data.data_selection.legend',
            self::DATA_SELECTION_TIME_POINT => 'data_management_plan.research_data.data_selection_time_point.legend',
            self::DATA_SELECTION_PROCEDURES => 'data_management_plan.research_data.data_selection_procedures.legend',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::EXISTING_DATA_REUSE => 'data_management_plan.research_data.existing_data_reuse.label',
            self::EXISTING_DATA_CITATION => 'data_management_plan.research_data.existing_data_citation.label',
            self::EXISTING_DATA_RELEVANCE => 'data_management_plan.research_data.existing_data_relevance.label',
            self::EXISTING_DATA_INTEGRATION => 'data_management_plan.research_data.existing_data_integration.label',
            self::RESEARCH_METHOD => 'data_management_plan.research_data.research_method.label',
            self::RESEARCH_METHOD_OTHER => 'data_management_plan.research_data.research_method_other.label',
            self::DATA_COLLECTION_REPRODUCIBILITY => 'data_management_plan.research_data.data_collection_reproducibility.label',
            self::COLLECTION_MODE => 'data_management_plan.research_data.collection_mode.label',
            self::COLLECTION_APPARATUS => 'data_management_plan.research_data.collection_apparatus.label',
            self::COLLECTION_MODE_OTHER => 'data_management_plan.research_data.collection_mode_other.label',
            self::RESEARCH_DESIGN => 'data_management_plan.research_data.research_design.label',
            self::DATA_COLLECTOR_TRAINING => 'data_management_plan.research_data.data_collector_training.label',
            self::CONSTRUCTS_MULTIPLE_MEASUREMENT => 'data_management_plan.research_data.constructs_multiple_measurement.label',
            self::QUALITY_ASSURANCE_OTHER => 'data_management_plan.research_data.quality_assurance_other.label',
            self::FILE_FORMATS => 'data_management_plan.research_data.file_formats.label',
            self::DATA_PRESERVATION_WORKING_COPY => 'data_management_plan.research_data.data_preservation_working_copy.label',
            self::DATA_PRESERVATION_GOOD_SCIENTIFIC_PRACTICE_PROOF => 'data_management_plan.research_data.data_preservation_good_scientific_practice_proof.label',
            self::DATA_PRESERVATION_REPRODUCIBILITY => 'data_management_plan.research_data.data_preservation_reproducibility.label',
            self::DATA_PRESERVATION_LEGAL_OBLIGATIONS => 'data_management_plan.research_data.data_preservation_legal_obligations.label',
            self::DATA_PRESERVATION_BEST_PRACTICE => 'data_management_plan.research_data.data_preservation_best_practice.label',
            self::STORAGE_DURATION => 'data_management_plan.research_data.storage_duration.label',
            self::DELETION_PROCEDURES => 'data_management_plan.research_data.deletion_procedures.label',
            self::DATA_SELECTION => 'data_management_plan.research_data.data_selection.label',
            self::DATA_SELECTION_TIME_POINT => 'data_management_plan.research_data.data_selection_time_point.label',
            self::DATA_SELECTION_PROCEDURES => 'data_management_plan.research_data.data_selection_procedures.label',
        };
    }

    public function placeholder(): ?string
    {
        return match ($this) {
            self::EXISTING_DATA_REUSE => 'data_management_plan.research_data.existing_data_reuse.placeholder',
            self::COLLECTION_MODE => 'data_management_plan.research_data.collection_mode.placeholder',
            self::RESEARCH_DESIGN => 'data_management_plan.research_data.research_design.placeholder',
            self::DATA_PRESERVATION_WORKING_COPY => 'data_management_plan.research_data.data_preservation_working_copy.placeholder',
            self::DATA_PRESERVATION_GOOD_SCIENTIFIC_PRACTICE_PROOF => 'data_management_plan.research_data.data_preservation_good_scientific_practice_proof.placeholder',
            self::DATA_PRESERVATION_REPRODUCIBILITY => 'data_management_plan.research_data.data_preservation_reproducibility.placeholder',
            self::DATA_PRESERVATION_LEGAL_OBLIGATIONS => 'data_management_plan.research_data.data_preservation_legal_obligations.placeholder',
            self::DATA_PRESERVATION_BEST_PRACTICE => 'data_management_plan.research_data.data_preservation_best_practice.placeholder',
            self::DATA_SELECTION => 'data_management_plan.research_data.data_selection.placeholder',
            default => null,
        };
    }

    public function help(): ?string
    {
        return match ($this) {
            self::RESEARCH_METHOD_OTHER => 'data_management_plan.research_data.research_method_other.help',
            self::EXISTING_DATA_RELEVANCE => 'data_management_plan.research_data.existing_data_relevance.help',
            self::EXISTING_DATA_INTEGRATION => 'data_management_plan.research_data.existing_data_integration.help',
            self::QUALITY_ASSURANCE_OTHER => 'data_management_plan.research_data.quality_assurance_other.help',
            self::DATA_SELECTION_PROCEDURES => 'data_management_plan.research_data.data_selection_procedures.help',
            default => null,
        };
    }

    public function descriptionHelp(): ?string
    {
        return match ($this) {
            self::EXISTING_DATA_REUSE => 'data_management_plan.research_data.existing_data_reuse',
            self::DATA_COLLECTION_REPRODUCIBILITY => 'data_management_plan.research_data.data_collection_reproducibility',
            self::FILE_FORMATS => 'data_management_plan.research_data.file_formats',
            self::DATA_PRESERVATION_WORKING_COPY => 'data_management_plan.research_data.data_preservation_working_copy',
            self::DATA_PRESERVATION_GOOD_SCIENTIFIC_PRACTICE_PROOF => 'data_management_plan.research_data.data_preservation_good_scientific_practice_proof',
            self::DATA_PRESERVATION_LEGAL_OBLIGATIONS => 'data_management_plan.research_data.data_preservation_legal_obligations',
            self::STORAGE_DURATION => 'data_management_plan.research_data.storage_duration',
            self::DELETION_PROCEDURES => 'data_management_plan.research_data.deletion_procedures',
            self::DATA_SELECTION => 'data_management_plan.research_data.data_selection',
            default => null,
        };
    }

    public function reviewData(): ReviewDataDto
    {
        return match ($this) {
            self::EXISTING_DATA_REUSE => new ReviewDataDto('data_management_plan.research_data.existing_data_reuse.error_message', ErrorType::RECOMMENDED),
            self::EXISTING_DATA_CITATION => new ReviewDataDto('data_management_plan.research_data.existing_data_citation.error_message', ErrorType::OPTIONAL),
            self::EXISTING_DATA_RELEVANCE => new ReviewDataDto('data_management_plan.research_data.existing_data_relevance.error_message', ErrorType::OPTIONAL),
            self::EXISTING_DATA_INTEGRATION => new ReviewDataDto('data_management_plan.research_data.existing_data_integration.error_message', ErrorType::OPTIONAL),
            self::RESEARCH_METHOD => new ReviewDataDto('data_management_plan.research_data.research_method.error_message', ErrorType::RECOMMENDED),
            self::RESEARCH_METHOD_OTHER => new ReviewDataDto('data_management_plan.research_data.research_method_other.error_message', ErrorType::OPTIONAL),
            self::DATA_COLLECTION_REPRODUCIBILITY => new ReviewDataDto('data_management_plan.research_data.data_collection_reproducibility.error_message', ErrorType::OPTIONAL),
            self::COLLECTION_MODE => new ReviewDataDto('data_management_plan.research_data.collection_mode.error_message', ErrorType::RECOMMENDED),
            self::COLLECTION_APPARATUS => new ReviewDataDto('data_management_plan.research_data.collection_apparatus.error_message', ErrorType::OPTIONAL),
            self::COLLECTION_MODE_OTHER => new ReviewDataDto('data_management_plan.research_data.collection_mode_other.error_message', ErrorType::OPTIONAL),
            self::RESEARCH_DESIGN => new ReviewDataDto('data_management_plan.research_data.research_design.error_message', ErrorType::RECOMMENDED),
            self::DATA_COLLECTOR_TRAINING => new ReviewDataDto('data_management_plan.research_data.data_collector_training.error_message', ErrorType::OPTIONAL),
            self::CONSTRUCTS_MULTIPLE_MEASUREMENT => new ReviewDataDto('data_management_plan.research_data.constructs_multiple_measurement.error_message', ErrorType::OPTIONAL),
            self::QUALITY_ASSURANCE_OTHER => new ReviewDataDto('data_management_plan.research_data.quality_assurance_other.error_message', ErrorType::OPTIONAL),
            self::FILE_FORMATS => new ReviewDataDto('data_management_plan.research_data.file_formats.error_message', ErrorType::RECOMMENDED),
            self::DATA_PRESERVATION_WORKING_COPY => new ReviewDataDto('data_management_plan.research_data.data_preservation_working_copy.error_message', ErrorType::RECOMMENDED),
            self::DATA_PRESERVATION_GOOD_SCIENTIFIC_PRACTICE_PROOF => new ReviewDataDto('data_management_plan.research_data.data_preservation_good_scientific_practice_proof.error_message', ErrorType::RECOMMENDED),
            self::DATA_PRESERVATION_REPRODUCIBILITY => new ReviewDataDto('data_management_plan.research_data.data_preservation_reproducibility.error_message', ErrorType::RECOMMENDED),
            self::DATA_PRESERVATION_LEGAL_OBLIGATIONS => new ReviewDataDto('data_management_plan.research_data.data_preservation_legal_obligations.error_message', ErrorType::RECOMMENDED),
            self::DATA_PRESERVATION_BEST_PRACTICE => new ReviewDataDto('data_management_plan.research_data.data_preservation_best_practice.error_message', ErrorType::RECOMMENDED),
            self::STORAGE_DURATION => new ReviewDataDto('data_management_plan.research_data.storage_duration.error_message', ErrorType::OPTIONAL),
            self::DELETION_PROCEDURES => new ReviewDataDto('data_management_plan.research_data.deletion_procedures.error_message', ErrorType::OPTIONAL),
            self::DATA_SELECTION => new ReviewDataDto('data_management_plan.research_data.data_selection.error_message', ErrorType::RECOMMENDED),
            self::DATA_SELECTION_TIME_POINT => new ReviewDataDto('data_management_plan.research_data.data_selection_time_point.error_message', ErrorType::OPTIONAL),
            self::DATA_SELECTION_PROCEDURES => new ReviewDataDto('data_management_plan.research_data.data_selection_procedures.error_message', ErrorType::OPTIONAL),
        };
    }
}
