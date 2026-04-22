<?php

namespace App\Service;

use App\Entity\FileManagement\Dataset;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use League\Flysystem\UnableToReadFile;
use Psr\Log\LoggerInterface;
use Symfony\Component\Process\Process;

readonly class SpssClient
{
    /**
     * SpssApiClient constructor.
     */
    public function __construct(
        private FilesystemOperator $datasetFilesystem,
        private LoggerInterface $logger,
    ) {
    }

    public function savToArray(?Dataset $dataset): ?array
    {
        if ($dataset === null) {
            return null;
        }

        $result = null;
        try {
            dump($dataset->getStorageName());
            $inputFile = tmpfile();
            fwrite($inputFile, $this->datasetFilesystem->read($dataset->getStorageName()));
            rewind($inputFile);
            $process = new Process(['python3', '../assets/scripts/savToCsv.py', stream_get_meta_data($inputFile)['uri']]);
            $process->run();
            fclose($inputFile);
            if (!$process->isSuccessful()) {
                $this->logger->error('SPSS conversion script failed: '.$process->getErrorOutput());
                throw new \RuntimeException('SPSS conversion script failed: '.$process->getErrorOutput());
            }
            $result = json_decode($process->getOutput(), true, 512, JSON_THROW_ON_ERROR);
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
