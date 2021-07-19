<?php


namespace App\Security\Authentication;


use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class OauthLogoutSubscriber implements EventSubscriberInterface
{
    private $clientRegistry;
    private $urlGenerator;

    public function __construct(ClientRegistry $clientRegistry, UrlGeneratorInterface $urlGenerator)
    {
        $this->clientRegistry = $clientRegistry;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * This function returns an array containing the subscribed events and the function that is called when the subscribed event is called.
     * Multiple Event => functions are possible.
     *
     * @return array|string[]
     */
    public static function getSubscribedEvents()
    {
        return [
            LogoutEvent::class => 'onLogoutEvent',
        ];
    }

    /**
     * This function handles the Keycloak logout event!
     *
     * @param LogoutEvent $event
     */
    public function onLogoutEvent(LogoutEvent $event)
    {
        if ($this->isRunningOnOauth()) {
            $provider = $this->clientRegistry->getClient('keycloak');
            $targetUrl = $this->urlGenerator->generate('Administration-landing', [], UrlGeneratorInterface::ABSOLUTE_URL);
            $logout = $provider->getOAuth2Provider()->getLogoutUrl(["redirect_uri" => $targetUrl]);
            $event->setResponse(new RedirectResponse($logout));
        }
    }

    private function isRunningOnOauth(): bool {
        return !getenv('APP_ENV') === 'local';
    }
}