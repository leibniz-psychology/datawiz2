<?php


namespace App\Api\Spss;


use App\Api\ApiClientService;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\FilesystemInterface;
use Oneup\UploaderBundle\Event\PostUploadEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mime\Part\DataPart;

class SpssApiClient
{

    const SPSS_API_URI = "http://datawiz.leibniz-psychology.org:8081/api/spss/tojson";

    private ApiClientService $clientService;
    private LoggerInterface $logger;
    private FilesystemInterface $filesystem;

    /**
     * SpssApiClient constructor.
     * @param FilesystemInterface $assetsFilesystem
     * @param ApiClientService $clientService
     * @param LoggerInterface $logger
     */
    public function __construct(FilesystemInterface $assetsFilesystem, ApiClientService $clientService, LoggerInterface $logger)
    {
        $this->clientService = $clientService;
        $this->logger = $logger;
        $this->filesystem = $assetsFilesystem;
    }


    public function savToArray(PostUploadEvent $event)
    {
        $result = null;
        if (null !== $event && null !== $event->getFile()) {
            try {
                $fileContent = $this->filesystem->read($event->getFile()->getBasename());
                $result = $this->clientService->POST(
                    self::SPSS_API_URI,
                    [
                        'file' => new DataPart($fileContent, $event->getFile()->getBasename(), $event->getFile()->getMimeType()),
                    ]
                );
            } catch (FileNotFoundException $e) {
                $this->logger->error("SpssApiClient::savToJson Exception thrown: {$e->getMessage()}");
            }
        }

        return $result;
    }


}