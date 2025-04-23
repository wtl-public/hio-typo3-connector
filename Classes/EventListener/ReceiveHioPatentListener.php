<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Psr\EventDispatcher\EventDispatcherInterface;
use Wtl\HioTypo3Connector\Domain\Repository\PatentRepository;
use Wtl\HioTypo3Connector\Event\AttachHioPatentToHioPersonsEvent;
use Wtl\HioTypo3Connector\Event\ReceiveHioPatentEvent;

class ReceiveHioPatentListener
{
    public function __construct(
        protected readonly PatentRepository $patentRepository,
        protected readonly EventDispatcherInterface $eventDispatcher
    )
    {
    }

    public function __invoke(ReceiveHioPatentEvent $event): void
    {
        $this->patentRepository->save($event->getHioPatent(), $event->getStoragePid());
        $hioPatentObjectId = $event->getHioPatent()->getObjectId();
        $hioPersonObjectIds = array_map(
            static fn($hioPerson) => $hioPerson->getObjectId(),
            $event->getHioPatent()->getPersons() ?? []
        );
        $this->eventDispatcher->dispatch(
            new AttachHioPatentToHioPersonsEvent(
                $hioPatentObjectId,
                $hioPersonObjectIds
            )
        );
    }
}
