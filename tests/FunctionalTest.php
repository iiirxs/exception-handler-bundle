<?php


namespace IIIRxs\ExceptionHandlerBundle\Tests;


use IIIRxs\ExceptionHandlerBundle\IIIRxsExceptionHandlerBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\Kernel;

class FunctionalTest extends TestCase
{

    public function testServiceWiring()
    {
        $kernel = new IIIRxsExceptionHandlerTestingKernel('prod', true);
        $kernel->boot();
        $container = $kernel->getContainer();

        $dispatcher = $container->get('event_dispatcher');
        $exceptionListener = $container->get('iiirxs_exception_handler.event_listener.exception_listener');

        $listeners = $dispatcher->getListeners();

        $this->assertArrayHasKey('kernel.exception', $listeners);

        $exceptionListeners = $listeners['kernel.exception'];
        $this->assertContains([ $exceptionListener, 'onKernelException' ], $exceptionListeners);
    }

}

class IIIRxsExceptionHandlerTestingKernel extends Kernel
{
    public function registerBundles()
    {
        return [
            new IIIRxsExceptionHandlerBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(function(ContainerBuilder $container) use ($loader) {
            $container->addCompilerPass(new RegisterListenersPass());
            $container->register('event_dispatcher', EventDispatcher::class)->setPublic(true);
        });
    }

}