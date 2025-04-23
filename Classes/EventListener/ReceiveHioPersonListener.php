<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Psr\EventDispatcher\EventDispatcherInterface;
use Wtl\HioTypo3Connector\Domain\Repository\PersonRepository;
use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioPublicationsEvent;
use Wtl\HioTypo3Connector\Event\ReceiveHioPersonEvent;

class ReceiveHioPersonListener
{
    public function __construct(
        protected readonly PersonRepository $personRepository,
        protected readonly EventDispatcherInterface $eventDispatcher
    )
    {
    }

    public function __invoke(ReceiveHioPersonEvent $event): void
    {
        $this->personRepository->save($event->getHioPerson(), $event->getStoragePid());
        $hioPersonObjectId  = $event->getHioPerson()->getObjectId();
        $hioPublicationObjectIds = array_map(
            static fn($hioPublication) => $hioPublication->getObjectId(),
            $event->getHioPerson()->getPublications() ?? []
        );
        $this->eventDispatcher->dispatch(
            new AttachHioPersonToHioPublicationsEvent(
                $hioPersonObjectId,
                $hioPublicationObjectIds
            )
        );
    }
}
