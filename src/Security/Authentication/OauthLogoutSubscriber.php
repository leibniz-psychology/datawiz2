<?php

namespace App\Security\Authentication;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Stevenmaguire\OAuth2\Client\Provider\Keycloak;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

readonly class OauthLogoutSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private ClientRegistry $clientRegistry,
        private UrlGeneratorInterface $urlGenerator
    ) {
    }

    /**
     * This function returns an array containing the subscribed events and the function that is called when the subscribed event is called.
     * Multiple Event => functions are possible.
     *
     * @return array|string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            LogoutEvent::class => 'onLogoutEvent',
        ];
    }

    /**
     * This function handles the Keycloak logout event!
     */
    public function onLogoutEvent(LogoutEvent $event): void
    {
        $provider = $this->clientRegistry->getClient('keycloak')->getOAuth2Provider();
        if (!$provider instanceof Keycloak) {
            throw new \Error('The authentication provider is not an instance of Keycloak!');
        }
        $targetUrl = $this->urlGenerator->generate('dashboard', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $logout = $provider->getLogoutUrl(['redirect_uri' => $targetUrl]);
        $event->setResponse(new RedirectResponse($logout));
    }
}
