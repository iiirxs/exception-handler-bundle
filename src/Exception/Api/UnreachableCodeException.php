<?php

namespace IIIRxs\ExceptionHandlerBundle\Exception\Api;

use IIIRxs\ExceptionHandlerBundle\Exception\ExceptionInterface;
use Symfony\Component\HttpFoundation\Response;

class UnreachableCodeException extends \Exception implements ExceptionInterface
{
    public function getStatusCode()
    {
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    public function getPayload()
    {
        return ['errors' => 'Code should not be reached'];
    }
}