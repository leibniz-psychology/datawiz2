<?php

namespace App\Controller;

use App\Entity\FileManagement\AdditionalMaterial;
use App\Entity\FileManagement\Dataset;
use App\Entity\Study\Experiment;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemOperator;
use League\Flysystem\UnableToReadFile;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[IsGranted('ROLE_USER')]
class ExportController extends AbstractController
{
    private readonly Serializer $serializer;

    public function __construct(private readonly LoggerInterface $logger, private readonly EntityManagerInterface $em, private readonly FilesystemOperator $datasetFilesystem, private readonly FilesystemOperator $matrixFilesystem, private readonly FilesystemOperator $materialFilesystem)
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader());
        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory);
        $this->serializer = new Serializer(
            [new DateTimeNormalizer(), new ObjectNormalizer($classMetadataFactory, $metadataAwareNameConverter)],
            ['json' => new JsonEncoder(), 'xml' => new XmlEncoder(), 'csv' => new CsvEncoder()]
        );
    }

    #[Route(path: '/export/{uuid}', name: 'export_index', methods: ['GET'])]
    public function exportIndex(string $uuid): Response
    {
        $this->logger->debug("Enter ExportController::exportAction(GET) for UUID: {$uuid}");
        $experiment = $this->em->getRepository(Experiment::class)->find($uuid);

        return $this->render('pages/export/export.html.twig', ['export_error' => null, 'experiment' => $experiment]);
    }

    #[Route(path: '/export/{uuid}', name: 'export_action', methods: ['POST'])]
    public function exportAction(Request $request, string $uuid): Response
    {
        $this->logger->debug("Enter ExportController::exportAction(POST) for UUID: {$uuid}");
        $experiment = $this->em->getRepository(Experiment::class)->find($uuid);
        $exportFormat = $request->get('exportFormat');
        $exportDataset = $request->get('exportDataset');
        $exportMaterial = $request->get('exportMaterial');
        if ($experiment) {
            $zip = new \ZipArchive();
            $zipError = false;
            $zipName = sys_get_temp_dir().'/'.$this->sanitizeFilename($experiment->getSettingsMetaDataGroup()->getShortName()).'.zip';
            if ($zip->open($zipName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
                $experiment->getOriginalDatasets()->clear();
                if ($exportDataset !== null && sizeof($exportDataset) != 0) {
                    foreach ($exportDataset as $dataset) {
                        $experiment->addOriginalDatasets($this->em->getRepository(Dataset::class)->find($dataset));
                    }
                    $zipError = $this->appendDatasetToZip($experiment, $exportFormat, $zip) ?: $zipError;
                }

                $experiment->getAdditionalMaterials()->clear();
                if ($exportMaterial !== null && sizeof($exportMaterial) != 0) {
                    foreach ($exportMaterial as $material) {
                        $experiment->addAdditionalMaterials($this->em->getRepository(AdditionalMaterial::class)->find($material));
                    }
                    $zipError = $this->appendMaterialToZip($experiment, $zip) ?: $zipError;
                }

                if ($request->get('exportStudy') === 'study') {
                    $zipError = $this->appendStudyToZip($experiment, $exportFormat, $zip) ?: $zipError;
                }

                if (!$zipError && $zip->numFiles != 0) {
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
                } else {
                    $this->logger->warning('ExportController::exportAction(POST): Error during creating ZIP file: Zip file is empty or corrupt');
                    $zip->addFromString('empty.txt', 'No file exported!');
                    $zip->close();
                    if ($zipError) {
                        $exportError = 'error.export.zip.create';
                    } else {
                        $exportError = 'error.export.zip.empty';
                    }
                }
                unlink($zipName);
            } else {
                $this->logger->critical('ExportController::exportAction(POST): Error during creating ZIP file: Could not create temp file for export');
                $exportError = 'error.export.zip.tempFile';
            }
        } else {
            $this->logger->critical('ExportController::exportAction(POST): Error during getting experiment: Experiment == null');
            $exportError = 'error.experiment.empty';
        }

        return $response ?? $this->render('pages/export/export.html.twig', ['export_error' => $exportError ?? null, 'experiment' => $experiment]);
    }

    /**
     * @return bool Error:True on failure, False on success
     */
    private function appendStudyToZip(Experiment $experiment, string $format, \ZipArchive &$zip): bool
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

        return !$zip->addFromString('study.'.$format, $json);
    }

    /**
     * @return bool Error:True on failure, False on success
     */
    private function appendDatasetToZip(Experiment $experiment, string $format, \ZipArchive &$zip): bool
    {
        $error = false;
        foreach ($experiment->getOriginalDatasets() as $dataset) {
            $folderName = $dataset->getOriginalName();
            if (str_contains((string) $folderName, '.')) {
                $folderName = explode('.', (string) $folderName)[0];
            }
            $folder = 'datasets/'.$this->sanitizeFilename($folderName);
            $error = $zip->addEmptyDir($folder) ? $error : true;
            try {
                if ($this->datasetFilesystem->has($dataset->getStorageName())) {
                    $error = $zip->addFromString(
                        "{$folder}/original_".$dataset->getOriginalName(),
                        $this->datasetFilesystem->read($dataset->getStorageName())
                    ) ? $error : true;
                }
                if ($this->matrixFilesystem->has("{$dataset->getId()}.csv")) {
                    $matrix = $this->matrixFilesystem->read("{$dataset->getId()}.csv");
                    if ($matrix) {
                        $matrix = $this->buildCSVHeader($dataset->getCodebook()).$matrix;
                        $error = $zip->addFromString("{$folder}/datamatrix.csv", $matrix) ? $error : true;
                    }
                }
            } catch (UnableToReadFile $e) {
                $this->logger->error("ExportController::appendDatasetToZip: Error read file from filesystem: {$e->getMessage()}");
                $error = true;
            }
            $error = $zip->addFromString(
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
            ) ? $error : true;
            if ($error) {
                break;
            }
        }

        return $error;
    }

    private function appendMaterialToZip(Experiment $experiment, \ZipArchive &$zip): mixed
    {
        $error = false;
        foreach ($experiment->getAdditionalMaterials() as $material) {
            if ($this->materialFilesystem->has($material->getStorageName())) {
                try {
                    $error = $zip->addFromString(
                        "material/{$material->getOriginalName()}",
                        $this->materialFilesystem->read($material->getStorageName())
                    ) ? $error : true;
                } catch (UnableToReadFile $e) {
                    $this->logger->error("ExportController::appendMaterialToZip: Error read file from filesystem: {$e->getMessage()}");
                    $error = true;
                }
            }
        }

        return $error;
    }

    private function buildCSVHeader(Collection $codebook): string
    {
        $header = [];
        foreach ($codebook as $var) {
            $header[] = $var->getName();
        }

        return implode(',', $header).PHP_EOL;
    }

    private function sanitizeFilename(?string $name): ?string
    {
        $chars = [' ', '"', "'", '&', '/', '\\', '?', '#', '<', '>', '.', ','];

        return $name != null ? strtolower(trim(str_replace($chars, '_', $name))) : 'unnamed';
    }
}