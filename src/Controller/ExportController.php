<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Dto\ExportDto;
use App\Entity\FileManagement\AdditionalMaterial;
use App\Entity\FileManagement\Dataset;
use App\Entity\Study\Experiment;
use App\Service\Study\StudyExportService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class ExportController extends AbstractController
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly EntityManagerInterface $em,
        private readonly StudyExportService $studyExportService,
    ) {
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

        $experiment->getOriginalDatasets()->clear();
        if ($export->datasets !== null && count($export->datasets) != 0) {
            foreach ($export->datasets as $dataset) {
                $experiment->addOriginalDatasets($this->em->getRepository(Dataset::class)->find($dataset));
            }
        }

        $experiment->getAdditionalMaterials()->clear();
        if ($export->materials !== null && count($export->materials) != 0) {
            foreach ($export->materials as $material) {
                $experiment->addAdditionalMaterials($this->em->getRepository(AdditionalMaterial::class)->find($material));
            }
        }

        $success = $this->studyExportService->exportStudy($experiment, $export->format, $zip);

        if (!$success || $zip->numFiles == 0) {
            $this->logger->warning('ExportController::exportAction(POST): Error during creating ZIP file: Zip file is empty or corrupt');
            $zip->addFromString('empty.txt', 'No file exported!');
            $zip->close();
            $exportError = $success ? 'error.export.zip.empty' : 'error.export.zip.create';
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

    private function sanitizeFilename(?string $name): string
    {
        $chars = [' ', '"', "'", '&', '/', '\\', '?', '#', '<', '>', '.', ','];

        return $name != null ? strtolower(trim(str_replace($chars, '_', $name))) : 'unnamed';
    }
}
