<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class RequestDurationSubscriber implements EventSubscriberInterface
{

    private $startedAt;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function startTimer(RequestEvent $event)
    {
        $this->startedAt = microtime(true);
    }

    public function endTimer(ResponseEvent $event)
    {
        $this->logger->info(sprintf('Мы насчитали, что запрос выполняется: %f мс',(microtime(true) - $this->startedAt) * 1000));
    }

    public static function getSubscribedEvents()
    {
        return [
            RequestEvent::class => 'startTimer',
            ResponseEvent::class => 'endTimer'
        ];
    }
}
