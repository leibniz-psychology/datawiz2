<?php

namespace App\Controller;

use App\Entity\Dto\ExportDto;
use App\Entity\FileManagement\AdditionalMaterial;
use App\Entity\FileManagement\Dataset;
use App\Entity\Study\Experiment;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use League\Flysystem\UnableToReadFile;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[IsGranted('ROLE_USER')]
class ExportController extends AbstractController
{
    private readonly Serializer $serializer;

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly EntityManagerInterface $em,
        private readonly FilesystemOperator $datasetFilesystem,
        private readonly FilesystemOperator $matrixFilesystem,
        private readonly FilesystemOperator $materialFilesystem
    ) {
        $classMetadataFactory = new ClassMetadataFactory(new AttributeLoader());
        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory);
        $this->serializer = new Serializer(
            [new DateTimeNormalizer(), new ObjectNormalizer($classMetadataFactory, $metadataAwareNameConverter)],
            ['json' => new JsonEncoder(), 'xml' => new XmlEncoder(), 'csv' => new CsvEncoder()]
        );
    }

    #[Route(path: '/export/{id}', name: 'export_index', methods: ['GET'])]
    public function exportIndex(Experiment $experiment): Response
    {
        $this->logger->debug("Enter ExportController::exportAction(GET) for UUID: {$experiment->getId()}");

        return $this->render('pages/export/export.html.twig', ['export_error' => null, 'experiment' => $experiment]);
    }

    #[Route(path: '/export/{id}', name: 'export_action', methods: ['POST'])]
    public function export(Experiment $experiment, #[MapRequestPayload] ExportDto $export): Response
    {
        $this->logger->debug("Enter ExportController::exportAction(POST) for UUID: {$experiment->getId()}");

        $zip = new \ZipArchive();
        $zipName = sys_get_temp_dir().'/'.$this->sanitizeFilename($experiment->getSettingsMetaDataGroup()->getShortName()).'.zip';

        if (!$zip->open($zipName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {
            $this->logger->critical('ExportController::exportAction(POST): Error during creating ZIP file: Could not create temp file for export');
            unlink($zipName);
            return $this->render('pages/export/export.html.twig', ['export_error' => 'error.export.zip.tempFile', 'experiment' => $experiment]);
        }

        $success = false;
        $experiment->getOriginalDatasets()->clear();
        if ($export->datasets !== null && sizeof($export->datasets) != 0) {
            foreach ($export->datasets as $dataset) {
                $experiment->addOriginalDatasets($this->em->getRepository(Dataset::class)->find($dataset));
            }
            $success = $this->appendDatasetsToZip($experiment, $export->format, $zip);
        }

        $experiment->getAdditionalMaterials()->clear();
        if ($export->materials !== null && sizeof($export->materials) != 0) {
            foreach ($export->materials as $material) {
                $experiment->addAdditionalMaterials($this->em->getRepository(AdditionalMaterial::class)->find($material));
            }
            $success = $this->appendMaterialToZip($experiment, $zip) && $success;
        }

        $success = $this->appendStudyToZip($experiment, $export->format, $zip) && $success;

        if (!$success || $zip->numFiles == 0) {
            $this->logger->warning('ExportController::exportAction(POST): Error during creating ZIP file: Zip file is empty or corrupt');
            $zip->addFromString('empty.txt', 'No file exported!');
            $zip->close();
            if ($success) {
                $exportError = 'error.export.zip.empty';
            } else {
                $exportError = 'error.export.zip.create';
            }
            unlink($zipName);
            return $this->render('pages/export/export.html.twig', ['export_error' => $exportError, 'experiment' => $experiment]);
        }

        $zip->close();
        $response = new Response(
            file_get_contents($zipName),
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/zip',
                'Content-Disposition' => 'attachment; filename="'.basename($zipName).'"',
                'Content-Length' => filesize($zipName),
            ]
        );

        unlink($zipName);

        return $response;
    }

    /**
     * @return bool TRUE on success or FALSE on failure
     */
    private function appendStudyToZip(Experiment $experiment, string $format, \ZipArchive $zip): bool
    {
        $design = $experiment->getMethodMetaDataGroup()->getResearchDesign(
        ) === 'Experimental' ? 'experimental' : ($experiment->getMethodMetaDataGroup()->getResearchDesign() === 'Non-experimental' ? 'non_experimental' : null);

        $json = $this->serializer->serialize(
            $experiment,
            $format,
            [
                'xml_root_node_name' => 'study',
                'xml_encoding' => 'utf-8',
                'xml_format_output' => true,
                AbstractNormalizer::GROUPS => ['study', $design, 'dataset', 'material'],
                'json_encode_options' => JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT,
            ]
        );

        return $zip->addFromString('study.'.$format, $json);
    }

    /**
     * @return bool TRUE on success or FALSE on failure
     */
    private function appendDatasetsToZip(Experiment $experiment, string $format, \ZipArchive $zip): bool
    {
        $success = true;
        foreach ($experiment->getOriginalDatasets() as $dataset) {
            $folderName = $dataset->getOriginalName();
            if (str_contains((string) $folderName, '.')) {
                $folderName = explode('.', (string) $folderName)[0];
            }
            $folder = 'datasets/'.$this->sanitizeFilename($folderName);

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
            $this->logger->error("ExportController::appendOriginalDatasetToZip: Unable to read file from filesystem: {$e->getMessage()}");
            $success = false;
        } catch (FilesystemException $e) {
            $this->logger->error("ExportController::appendOriginalDatasetToZip: FilesystemException: {$e->getMessage()}");
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
    private function appendMaterialToZip(Experiment $experiment, \ZipArchive $zip): bool
    {
        $success = true;
        foreach ($experiment->getAdditionalMaterials() as $material) {
            try {
                if ($this->materialFilesystem->has($material->getStorageName())) {
                    $success = $zip->addFromString(
                        "material/{$material->getOriginalName()}",
                        $this->materialFilesystem->read($material->getStorageName())
                    ) && $success;
                }
            } catch (UnableToReadFile $e) {
                $this->logger->error("ExportController::appendMaterialToZip: Unable to read file from filesystem: {$e->getMessage()}");
                $success = false;
            } catch (FilesystemException $e) {
                $this->logger->error("ExportController::appendMaterialToZip: FilesystemException: {$e->getMessage()}");
                $success = false;
            }
        }

        return $success;
    }

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
