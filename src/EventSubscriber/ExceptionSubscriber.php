<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public function __construct(private RouterInterface $router) {}

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.exception' => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (
            $exception instanceof AccessDeniedHttpException ||
            $exception instanceof NotFoundHttpException
        ) {
            $response = new RedirectResponse(
                $this->router->generate('app_home')
            );

            $event->setResponse($response);
        }
    }
}

