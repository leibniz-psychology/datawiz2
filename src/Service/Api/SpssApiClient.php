<?php

namespace App\Service\Api;

use App\Entity\FileManagement\Dataset;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use League\Flysystem\UnableToReadFile;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mime\Part\DataPart;

readonly class SpssApiClient
{
    /**
     * SpssApiClient constructor.
     */
    public function __construct(
        private FilesystemOperator $datasetFilesystem,
        private ApiClientService $clientService,
        private LoggerInterface $logger,
        private string $spss_uri
    ) {
    }

    public function savToArray(?Dataset $dataset): array|null
    {
        if ($dataset === null) {
            return null;
        }

        $result = null;
        try {
            $fileContent = $this->datasetFilesystem->read($dataset->getStorageName());
            $result = $this->clientService->POST(
                $this->spss_uri.'/spss/tojson',
                [
                    'file' => new DataPart($fileContent, $dataset->getStorageName(), $dataset->getOriginalMimetype()),
                ]
            );
        } catch (UnableToReadFile $e) {
            $this->logger->error("SpssApiClient::savToJson Unable to read file: {$e->getMessage()}");
        } catch (FilesystemException $e) {
            $this->logger->error("SpssApiClient::savToJson FilesystemException: {$e->getMessage()}");
        } catch (\JsonException $e) {
            $this->logger->error("SpssApiClient::savToJson JsonException: {$e->getMessage()}");
        }

        return $result;
    }
}
