<?php

declare(strict_types = 1);

namespace CodelyTv\Shared\Infrastructure\Symfony;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use function Lambdish\Phunctional\get;

final class BasicHttpAuthMiddleware
{
    private static $validUsers = [
        'javi' => 'barbitas',
        'rafa' => 'pelazo',
    ];

    public function onKernelRequest(RequestEvent $event): void
    {
        $shouldAuthenticate = $event->getRequest()->attributes->get('auth', false);

        if ($shouldAuthenticate) {
            $user = $event->getRequest()->headers->get('php-auth-user');
            $pass = $event->getRequest()->headers->get('php-auth-pw');

            $this->hasIntroducedCredentials($user)
                ? $this->authenticate($user, $pass, $event)
                : $this->askForCredentials($event);
        }
    }

    private function hasIntroducedCredentials(?string $user): bool
    {
        return null !== $user;
    }

    private function authenticate(string $user, string $pass, RequestEvent $event): void
    {
        if (!$this->isValid($user, $pass)) {
            $event->setResponse(new JsonResponse(['error' => 'Invalid credentials'], Response::HTTP_FORBIDDEN));
        }

        $this->addUserDataToRequest($user, $event);
    }

    private function isValid(?string $user, ?string $pass): bool
    {
        return get($user, self::$validUsers, false) && $pass === self::$validUsers[$user];
    }

    private function addUserDataToRequest(string $user, RequestEvent $event): void
    {
        $event->getRequest()->attributes->set('authentication_username', $user);
    }

    private function askForCredentials(RequestEvent $event): void
    {
        $event->setResponse(
            new Response('', Response::HTTP_UNAUTHORIZED, ['WWW-Authenticate' => 'Basic realm="CodelyTV"'])
        );
    }
}
