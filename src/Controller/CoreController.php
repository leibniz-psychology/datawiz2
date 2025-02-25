<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\CachingHttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpCache\Store;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CoreController extends AbstractController
{
    private readonly CachingHttpClient $client;

    /**
     * CoreController constructor.
     */
    public function __construct(
        private readonly LoggerInterface $logger,
        HttpClientInterface $client
    ) {
        $this->client = new CachingHttpClient($client, new Store('var/cache/http'));
    }

    #[Route(
        path: '/{_locale}/microsite_footer',
        name: 'core_microsite_footer',
        requirements: ['_locale' => 'en|de'],
        locale: 'en'
    )]
    public function getFooterFromAssets(Request $request): Response
    {
        $content = null;
        try {
            $response = $this->client->request(
                'GET',
                'https://www.lifp.de/assets/collapsible-footer/index.php?framework=css&lang='.$request->getLocale()
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode == Response::HTTP_OK) {
                $content = $response->getContent();
            }
        } catch (ExceptionInterface $e) {
            $this->logger->error($e->getMessage());
            // do whatever you want to do!
        }
        return new Response(
            $content,
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );
    }
}
