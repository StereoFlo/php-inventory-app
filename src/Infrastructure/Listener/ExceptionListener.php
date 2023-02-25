<?php

namespace App\Infrastructure\Listener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionListener implements EventSubscriberInterface
{

    public function __construct(private readonly LoggerInterface $logger) {}

    /**
     * @return array<string, mixed>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException'],
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $this->logger->error($exception->getMessage(), $exception->getTrace());
        $response = new JsonResponse([
            'meta' => ['success' => false],
            'data' => $exception->getMessage(),
        ]);
        $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        $event->setResponse($response);
    }
}