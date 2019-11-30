<?php

namespace IIIRxs\ExceptionHandlerBundle\EventListener;

use IIIRxs\ExceptionHandlerBundle\Exception\ExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $request = $event->getRequest();

        if ($request->isXmlHttpRequest()) {
            if ($exception instanceof ExceptionInterface) {
                $this->setExceptionResponse($event, $exception->getPayload(), $exception->getStatusCode());
            }
        }
    }

    /**
     * @param ExceptionEvent $event
     * @param array $payload
     * @param int $statusCode
     */
    private function setExceptionResponse(
        ExceptionEvent $event,
        array $payload,
        int $statusCode
    )
    {
        $response = new JsonResponse($payload);
        $response->setStatusCode($statusCode);
        $event->allowCustomResponseCode();
        $event->setResponse($response);
    }

}
