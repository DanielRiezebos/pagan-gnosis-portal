<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class StrikeSubscriber implements EventSubscriberInterface
{
    private TokenStorageInterface $tokenStorage;
    private RouterInterface $router;

    public function __construct(TokenStorageInterface $tokenStorage, RouterInterface $router)
    {
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $token = $this->tokenStorage->getToken();

        /* User $user */
        if (!$token || !is_object($user = $token->getUser())) {
            return;
        }

        if (method_exists($user, 'getStrikes') && $user->getStrikes() >= USER::MAX_STRIKES) {
            // Invalidate session
            $event->getRequest()->getSession()->invalidate();
            // Redirect to logout or login page\
            $event->setResponse(new RedirectResponse($this->router->generate('app_logout')));
            $event->stopPropagation();
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}
