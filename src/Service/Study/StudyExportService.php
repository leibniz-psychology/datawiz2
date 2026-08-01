<?php

declare(strict_types=1);

namespace App\Service\Study;

use App\Entity\Codebook\DatasetVariables;
use App\Entity\FileManagement\AdditionalMaterial;
use App\Entity\FileManagement\Dataset;
use App\Entity\Study\Experiment;
use Doctrine\Common\Collections\Collection;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use League\Flysystem\UnableToReadFile;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Appends the "normal study export" content (metadata, datasets and materials) to a zip archive.
 */
final readonly class StudyExportService
{
    public function __construct(
        private LoggerInterface $logger,
        private SerializerInterface $serializer,
        private FilesystemOperator $datasetFilesystem,
        private FilesystemOperator $matrixFilesystem,
        private FilesystemOperator $materialFilesystem,
    ) {
    }

    /**
     * @return bool TRUE on success or FALSE on failure
     */
    public function exportStudy(Experiment $experiment, string $format, \ZipArchive $zip, string $folder = ''): bool
    {
        $base = $folder === '' ? '' : $folder.'/';

        $success = $this->appendStudyToZip($experiment, $format, $base, $zip);
        $success = $this->appendDatasetsToZip($experiment, $format, $base, $zip) && $success;
        return $this->appendMaterialToZip($experiment, $base, $zip) && $success;
    }

    /**
     * @return bool TRUE on success or FALSE on failure
     */
    private function appendStudyToZip(Experiment $experiment, string $format, string $base, \ZipArchive $zip): bool
    {
        return $zip->addFromString(
            $base.'study.'.$format,
            $this->serializer->serialize(
                $experiment,
                $format,
                [
                    'xml_root_node_name' => 'study',
                    'xml_encoding' => 'utf-8',
                    'xml_format_output' => true,
                    AbstractNormalizer::GROUPS => ['study', 'dataset', 'material'],
                    'json_encode_options' => JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT,
                ]
            )
        );
    }

    /**
     * @return bool TRUE on success or FALSE on failure
     */
    private function appendDatasetsToZip(Experiment $experiment, string $format, string $base, \ZipArchive $zip): bool
    {
        $success = true;
        foreach ($experiment->getOriginalDatasets() as $dataset) {
            $folderName = $dataset->getOriginalName();
            if (str_contains((string) $folderName, '.')) {
                $folderName = explode('.', (string) $folderName)[0];
            }
            $folder = $base.'datasets/'.$this->sanitizeFilename($folderName);

            $success = $zip->addEmptyDir($folder);
            $success = $this->appendDatasetFileToZip($dataset, $folder, $zip) && $success;
            $success = $this->appendCodebookToZip($dataset, $folder, $format, $zip) && $success;

            if (!$success) {
                break;
            }
        }

        return $success;
    }

    /**
     * @return bool TRUE on success or FALSE on failure
     */
    private function appendDatasetFileToZip(Dataset $dataset, string $folder, \ZipArchive $zip): bool
    {
        $success = true;
        try {
            if ($this->datasetFilesystem->has($dataset->getStorageName())) {
                $success = $zip->addFromString(
                    "{$folder}/original_".$dataset->getOriginalName(),
                    $this->datasetFilesystem->read($dataset->getStorageName())
                );
            }
            if ($this->matrixFilesystem->has("{$dataset->getId()}.csv")) {
                $matrix = $this->matrixFilesystem->read("{$dataset->getId()}.csv");
                if ($matrix) {
                    $matrix = $this->buildCSVHeader($dataset->getCodebook()).$matrix;
                    $success = $zip->addFromString("{$folder}/datamatrix.csv", $matrix) && $success;
                }
            }
        } catch (UnableToReadFile $e) {
            $this->logger->error("StudyExportService::appendDatasetFileToZip: Unable to read file from filesystem: {$e->getMessage()}");
            $success = false;
        } catch (FilesystemException $e) {
            $this->logger->error("StudyExportService::appendDatasetFileToZip: FilesystemException: {$e->getMessage()}");
            $success = false;
        }

        return $success;
    }

    /**
     * @return bool TRUE on success or FALSE on failure
     */
    private function appendCodebookToZip(Dataset $dataset, string $folder, string $format, \ZipArchive $zip): bool
    {
        return $zip->addFromString(
            "{$folder}/codebook.{$format}",
            $this->serializer->serialize(
                $dataset->getCodebook(),
                $format,
                [
                    'xml_root_node_name' => 'codebook',
                    'xml_encoding' => 'utf-8',
                    'xml_format_output' => true,
                    AbstractNormalizer::GROUPS => ['codebook'],
                    'json_encode_options' => JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT,
                ]
            )
        );
    }

    /**
     * @return bool TRUE on success or FALSE on failure
     */
    private function appendMaterialToZip(Experiment $experiment, string $base, \ZipArchive $zip): bool
    {
        $success = true;
        foreach ($experiment->getAdditionalMaterials() as $material) {
            $success = $this->appendMaterialFileToZip($material, $base, $zip) && $success;
        }

        return $success;
    }

    /**
     * @return bool TRUE on success or FALSE on failure
     */
    private function appendMaterialFileToZip(AdditionalMaterial $material, string $base, \ZipArchive $zip): bool
    {
        $success = true;
        try {
            if ($this->materialFilesystem->has($material->getStorageName())) {
                $success = $zip->addFromString(
                    $base.'material/'.$material->getOriginalName(),
                    $this->materialFilesystem->read($material->getStorageName())
                );
            }
        } catch (UnableToReadFile $e) {
            $this->logger->error("StudyExportService::appendMaterialFileToZip: Unable to read file from filesystem: {$e->getMessage()}");
            $success = false;
        } catch (FilesystemException $e) {
            $this->logger->error("StudyExportService::appendMaterialFileToZip: FilesystemException: {$e->getMessage()}");
            $success = false;
        }

        return $success;
    }

    /**
     * @param Collection<int, DatasetVariables> $codebook
     */
    private function buildCSVHeader(Collection $codebook): string
    {
        $header = [];
        foreach ($codebook as $var) {
            $header[] = $var->getName();
        }

        return implode(',', $header).PHP_EOL;
    }

    private function sanitizeFilename(?string $name): string
    {
        $chars = [' ', '"', "'", '&', '/', '\\', '?', '#', '<', '>', '.', ','];

        return $name != null ? strtolower(trim(str_replace($chars, '_', $name))) : 'unnamed';
    }
}
