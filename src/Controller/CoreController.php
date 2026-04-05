<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CoreController extends AbstractController
{
    /**
     * CoreController constructor.
     */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly HttpClientInterface $client,
        private readonly CacheInterface $cache,
    ) {
    }

    #[Route(
        path: '/{_locale}/microsite_footer',
        name: 'core_microsite_footer',
        requirements: ['_locale' => 'en|de'],
        locale: 'en'
    )]
    public function getFooterFromAssets(Request $request): Response
    {
        $content = $this->cache->get('app_microsite_footer', function (ItemInterface $item) use ($request): string {
            $item->expiresAfter(24 * 60 * 60);
            try {
                $content = null;
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
            }
            return $content;
        });

        return new Response(
            $content,
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );
    }
}
