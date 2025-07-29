<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Psr\EventDispatcher\EventDispatcherInterface;
use Wtl\HioTypo3Connector\Domain\Repository\ResearchInfrastructureRepository;
use Wtl\HioTypo3Connector\Event\ReceiveHioResearchInfrastructureEvent;

class ReceiveHioResearchInfrastructureListener
{
    public function __construct(
        protected readonly ResearchInfrastructureRepository $repository,
        protected readonly EventDispatcherInterface $eventDispatcher
    )
    {
    }

    public function __invoke(ReceiveHioResearchInfrastructureEvent $event): void
    {
        $this->repository->save($event->getHioResearchInfrastructure(), $event->getStoragePid());
    }
}
