<?php

namespace App\Security\Authentication;

use App\Crud\Crudable;
use App\Domain\Model\Administration\DataWizUser;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Uid\Uuid;

class OauthAuthenticator extends SocialAuthenticator
{
    use TargetPathTrait;

    private $clientRegistry;
    private $crud;
    private $urlGenerator;

    public function __construct(
        ClientRegistry $clientRegistry,
        Crudable $crud,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->clientRegistry = $clientRegistry;
        $this->crud = $crud;
        $this->urlGenerator = $urlGenerator;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse('/', Response::HTTP_TEMPORARY_REDIRECT);
    }

    public function supports(Request $request)
    {
        return $request->attributes->get('_route') === 'Security-check';
    }

    public function getCredentials(Request $request)
    {
        return $this->fetchAccessToken(
            $this->clientRegistry
                ->getClient('keycloak')
        );
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $keycloakUser = $this->clientRegistry
            ->getClient('keycloak')
            ->fetchUserFromToken($credentials);

        $userAtSignIn = $this->crud->readById(DataWizUser::class, $keycloakUser->getId());
        // TODO: This is logic for an custom UserProvider - should be part of the loadUserByIdentifier method
        if ($userAtSignIn === null && array_key_exists('email', $keycloakUser->toArray())) {
            $userAtSignIn = new DataWizUser($keycloakUser->toArray()['email']);
            $userAtSignIn->setId(new Uuid($keycloakUser->getId()));
            $this->crud->update($userAtSignIn);
        }

        return $userAtSignIn;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $message = strtr($exception->getMessageKey(), $exception->getMessageData());

        return new Response($message, Response::HTTP_FORBIDDEN);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // Redirect to previous selected route
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('dashboard'));
    }
}
