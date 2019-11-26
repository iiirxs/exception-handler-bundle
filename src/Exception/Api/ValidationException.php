<?php

namespace IIIRxs\ExceptionHandlerBundle\Exception\Api;

use IIIRxs\ExceptionHandlerBundle\Exception\ExceptionInterface;

class ValidationException extends \Exception implements ExceptionInterface
{

    /** @var array */
    private $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;

        parent::__construct();
    }

    public function getStatusCode()
    {
        return 440;
    }

    public function getPayload()
    {
        return ['errors' => $this->errors];
    }

}