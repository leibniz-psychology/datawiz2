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
    public function __construct(private readonly HttpClientInterface $client, private readonly LoggerInterface $logger)
    {
    }

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
            if ($response && $response->getStatusCode() == 200) {
                $content = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
            }
        } catch (TransportExceptionInterface|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $e) {
            $this->logger->error("HttpClientService::GET - Exception thrown: {$e->getMessage()}");
        }

        return $content;
    }

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
            if ($response && $response->getStatusCode() == 200) {
                $content = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
            }
        } catch (TransportExceptionInterface|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $e) {
            $this->logger->error("HttpClientService::POST - Exception thrown: {$e->getMessage()}");
        }

        return $content;
    }
}
