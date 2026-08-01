<?php

declare(strict_types=1);

namespace App\Service\Project;

use App\Entity\DataManagementPlan\DataManagementPlan;
use App\Entity\Project\Project;
use App\Entity\Study\Experiment;
use App\Service\Study\StudyExportService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Creates a ZIP archive containing the project administrative data, its studies
 * and its data management plans.
 */
final readonly class ProjectExportService
{
    private const string STUDIES_FOLDER = 'studies';

    private const string DMP_FOLDER = 'data management plans';

    public function __construct(
        private LoggerInterface $logger,
        private SerializerInterface $serializer,
        private StudyExportService $studyExportService,
    ) {
    }

    /**
     * @return null|string Path to the created ZIP file or NULL on failure
     */
    public function createExportZip(Project $project, string $format): ?string
    {
        $zipName = sys_get_temp_dir().'/'.$this->sanitizeFilename($this->getProjectShortName($project)).'.zip';
        $zip = new \ZipArchive();

        if (!$zip->open($zipName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {
            $this->logger->critical('ProjectExportService::createExportZip: Could not create temp file for export');
            unlink($zipName);
            return null;
        }

        $success = $zip->addFromString(
            'project.'.$format,
            $this->serializer->serialize(
                $project,
                $format,
                [
                    'xml_root_node_name' => 'project',
                    'xml_encoding' => 'utf-8',
                    'xml_format_output' => true,
                    AbstractNormalizer::GROUPS => ['project'],
                    'json_encode_options' => JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT,
                ]
            )
        );

        foreach ($project->getExperiments() as $experiment) {
            $folder = self::STUDIES_FOLDER.'/'.$this->getStudyFolderName($experiment);
            $success = $this->studyExportService->exportStudy($experiment, $format, $zip, $folder) && $success;
        }

        foreach ($project->getDataManagementPlans() as $dataManagementPlan) {
            $filename = $this->getDataManagementPlanFileName($dataManagementPlan, $format);
            $success = $zip->addFromString(
                self::DMP_FOLDER.'/'.$filename,
                $this->serializer->serialize(
                    $dataManagementPlan,
                    $format,
                    [
                        'xml_root_node_name' => 'data_management_plan',
                        'xml_encoding' => 'utf-8',
                        'xml_format_output' => true,
                        AbstractNormalizer::GROUPS => ['data_management_plan'],
                        'json_encode_options' => JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT,
                    ]
                )
            ) && $success;
        }

        if (!$success || $zip->numFiles == 0) {
            $this->logger->warning('ProjectExportService::createExportZip: Zip file is empty or corrupt');
            $zip->close();
            unlink($zipName);
            return null;
        }

        $zip->close();

        return $zipName;
    }

    private function getProjectShortName(Project $project): string
    {
        $shortName = $project->getSettings()?->getShortName();
        if ($shortName !== null && trim($shortName) !== '') {
            return $shortName;
        }

        return $project->getAdministrativeData()?->getProjectTitle() ?? 'project';
    }

    private function getStudyFolderName(Experiment $experiment): string
    {
        $shortName = $experiment->getSettingsMetaDataGroup()->getShortName();
        if ($shortName === null || trim($shortName) === '') {
            return (string) $experiment->getId();
        }

        return $this->sanitizeFilename($shortName);
    }

    private function getDataManagementPlanFileName(DataManagementPlan $dataManagementPlan, string $format): string
    {
        $shortName = $dataManagementPlan->getSettings()?->getShortName();
        if ($shortName === null || trim($shortName) === '') {
            return (string) $dataManagementPlan->getId().'.'.$format;
        }

        return $this->sanitizeFilename($shortName).'.'.$format;
    }

    private function sanitizeFilename(?string $name): string
    {
        $chars = [' ', '"', "'", '&', '/', '\\', '?', '#', '<', '>', '.', ','];

        return $name != null ? strtolower(trim(str_replace($chars, '_', $name))) : 'unnamed';
    }
}
