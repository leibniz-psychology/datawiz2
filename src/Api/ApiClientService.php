<?php


namespace App\Api;


use Psr\Log\LoggerInterface;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiClientService
{
    private HttpClientInterface $client;
    private LoggerInterface $logger;

    /**
     * HttpClientService constructor.
     * @param HttpClientInterface $client
     * @param LoggerInterface $debugLogger
     */
    public function __construct(HttpClientInterface $client, LoggerInterface $debugLogger)
    {
        $this->client = $client;
        $this->logger = $debugLogger;
    }

    /**
     *
     * @param string $uri
     * @param array $params
     * @return mixed|null
     */
    public function GET(string $uri, array $params): ?array
    {
        $this->logger->debug("HttpClientService::GET - Enter [URI: {$uri}]");
        $content = null;
        try {
            $response = $this->client->request(
                'GET',
                $uri,
                [
                    'query' => $params,
                ]
            );
            if ($response && 200 == $response->getStatusCode()) {
                $content = json_decode($response->getContent(), true);
            }
        } catch (TransportExceptionInterface | ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface $e) {
            $this->logger->error("HttpClientService::GET - Exception thrown: {$e->getMessage()}");
        }

        return $content;
    }

    /**
     *
     * @param string $uri
     * @param array $params
     * @return mixed|null
     */
    public function POST(string $uri, array $params): ?array
    {
        $this->logger->debug("HttpClientService::POST - Enter [URI: {$uri}]");
        $content = null;
        $formData = new FormDataPart($params);
        try {
            $response = $this->client->request(
                'POST',
                $uri,
                [
                    'headers' => $formData->getPreparedHeaders()->toArray(),
                    'body' => $formData->bodyToIterable(),
                ]
            );
            if ($response && 200 == $response->getStatusCode()) {
                $content = json_decode($response->getContent(), true);
            }
        } catch (TransportExceptionInterface | ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface $e) {
            $this->logger->error("HttpClientService::POST - Exception thrown: {$e->getMessage()}");
        }

        return $content;
    }


}