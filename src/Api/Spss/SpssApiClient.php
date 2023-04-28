<?php


namespace App\Api\Spss;


use App\Api\ApiClientService;
use App\Domain\Model\Filemanagement\Dataset;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\FilesystemInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mime\Part\DataPart;

class SpssApiClient
{

    /**
     * SpssApiClient constructor.
     */
    public function __construct(private readonly FilesystemInterface $assetsFilesystem, private readonly ApiClientService $clientService, private readonly LoggerInterface $logger, private readonly string $spss_uri)
    {
    }


    public function savToArray(?Dataset $dataset)
    {
        $result = null;
        if (null != $dataset) {
            try {
                $fileContent = $this->assetsFilesystem->read($dataset->getStorageName());
                $result = $this->clientService->POST(
                    $this->spss_uri.'/spss/tojson',
                    [
                        'file' => new DataPart($fileContent, $dataset->getStorageName(), $dataset->getOriginalMimetype()),
                    ]
                );
            } catch (FileNotFoundException $e) {
                $this->logger->error("SpssApiClient::savToJson Exception thrown: {$e->getMessage()}");
            }
        }

        return $result;
    }


}