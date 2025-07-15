<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Psr\EventDispatcher\EventDispatcherInterface;
use Wtl\HioTypo3Connector\Domain\Repository\SpinOffRepository;
use Wtl\HioTypo3Connector\Event\ReceiveHioSpinOffEvent;

class ReceiveHioSpinOffListener
{
    public function __construct(
        protected readonly SpinOffRepository $spinOffRepository,
        protected readonly EventDispatcherInterface $eventDispatcher
    )
    {
    }

    public function __invoke(ReceiveHioSpinOffEvent $event): void
    {
        $this->spinOffRepository->save($event->getHioSpinOff(), $event->getStoragePid());
    }
}
