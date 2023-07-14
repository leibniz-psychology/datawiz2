<?php

namespace App\Security\Authentication;

use App\Entity\Administration\DataWizUser;
use App\Entity\Constant\UserRoles;
use App\Service\Crud\Crudable;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Uid\Uuid;

class OauthAuthenticator extends OAuth2Authenticator implements AuthenticationEntryPointInterface
{
    use TargetPathTrait;

    public function __construct(
        private readonly ClientRegistry $clientRegistry,
        private readonly Crudable $crud,
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function authenticate(Request $request): SelfValidatingPassport
    {
        $client = $this->clientRegistry->getClient('keycloak');
        $accessToken = $this->fetchAccessToken($client);

        return new SelfValidatingPassport(
            new UserBadge($accessToken->getToken(), function () use ($accessToken, $client) {
                $keycloakUser = $client->fetchUserFromToken($accessToken);
                $user = $this->crud->readById(DataWizUser::class, $keycloakUser->getId());
                $kcArray = $keycloakUser->toArray();

                if (is_iterable($kcArray)) {
                    if ($user === null) {
                        $user = new DataWizUser();
                        $user->setId(new Uuid($keycloakUser->getId()));
                        $user->setRoles([UserRoles::USER]);
                        $user->setDateRegistered(new \DateTime());
                    }
                    if (key_exists('email', $kcArray)) {
                        $user->setEmail($kcArray['email']);
                    }
                    if (key_exists('given_name', $kcArray)) {
                        $user->setFirstname($kcArray['given_name']);
                    }
                    if (key_exists('family_name', $kcArray)) {
                        $user->setLastname($kcArray['family_name']);
                    }
                    $user->setLastLogin(new \DateTime());
                    $this->crud->update($user);
                }

                return $user;
            })
        );
    }

    public function start(Request $request, AuthenticationException $authException = null): RedirectResponse
    {
        return new RedirectResponse('/', Response::HTTP_TEMPORARY_REDIRECT);
    }

    public function supports(Request $request): bool
    {
        return $request->attributes->get('_route') === 'Security-check';
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        $message = strtr($exception->getMessageKey(), $exception->getMessageData());

        return new Response($message, Response::HTTP_FORBIDDEN);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): RedirectResponse
    {
        // Redirect to previous selected route
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('dashboard'));
    }
}
