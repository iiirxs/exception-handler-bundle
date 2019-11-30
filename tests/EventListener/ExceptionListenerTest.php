<?php


namespace IIIRxs\ExceptionHandlerBundle\Tests\EventListener;


use IIIRxs\ExceptionHandlerBundle\EventListener\ExceptionListener;
use IIIRxs\ExceptionHandlerBundle\Exception\Api\ValidationException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListenerTest extends TestCase
{

    public function testOnKernelException()
    {
        $listener = new ExceptionListener();

        $request = $this->createMock(Request::class);
        $request
            ->expects($this->once())
            ->method('isXmlHttpRequest')
            ->willReturn(true)
        ;

        $exceptionEvent = $this->createMock(ExceptionEvent::class);

        $exceptionEvent
            ->expects($this->once())
            ->method('getThrowable')
            ->willReturn(new ValidationException([]))
        ;

        $exceptionEvent
            ->expects($this->once())
            ->method('getRequest')
            ->willReturn($request)
        ;

        $exceptionEvent
            ->expects($this->once())
            ->method('allowCustomResponseCode')
        ;

        $jsonResponse = new JsonResponse([ 'errors' => [] ]);
        $jsonResponse->setStatusCode(440);

        $exceptionEvent
            ->expects($this->once())
            ->method('setResponse')
            ->with($this->equalTo($jsonResponse))
        ;

        $listener->onKernelException($exceptionEvent);
    }

}