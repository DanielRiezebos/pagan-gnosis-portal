<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

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
        if (!$token || !is_object($user = $token->getUser())) {
            return;
        }
        // Assuming your User entity has a getStrikes() method
        if (method_exists($user, 'getStrikes') && $user->getStrikes() > 2) {
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
