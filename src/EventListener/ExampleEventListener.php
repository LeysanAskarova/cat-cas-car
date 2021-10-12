<?php


namespace App\EventListener;


use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class ExampleEventListener
{


    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {

        $this->logger = $logger;
    }

    public function onEventHappen(RequestEvent $requestEvent)
    {
        $this->logger->info(sprintf('Был вызван обработчик события %s', __METHOD__));
    }
}