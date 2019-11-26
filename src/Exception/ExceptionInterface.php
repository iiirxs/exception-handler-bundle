<?php

namespace IIIRxs\ExceptionHandlerBundle\Exception;

interface ExceptionInterface
{
    const MESSAGE_FIELD = 'message';

    public function getStatusCode();

    public function getPayload();

}
