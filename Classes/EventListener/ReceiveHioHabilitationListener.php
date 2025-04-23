<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Psr\EventDispatcher\EventDispatcherInterface;
use Wtl\HioTypo3Connector\Domain\Repository\HabilitationRepository;
use Wtl\HioTypo3Connector\Event\AttachHioHabilitationToHioPersonsEvent;
use Wtl\HioTypo3Connector\Event\ReceiveHioHabilitationEvent;

class ReceiveHioHabilitationListener
{
    public function __construct(
        protected readonly HabilitationRepository $habilitationRepository,
        protected readonly EventDispatcherInterface $eventDispatcher
    )
    {
    }
    public function __invoke(ReceiveHioHabilitationEvent $event): void
    {
        $this->habilitationRepository->save($event->getHioHabilitation(), $event->getStoragePid());
        $hioHabilitationObjectId = $event->getHioHabilitation()->getObjectId();
        $hioPersonObjectIds = array_map(
            static fn($hioPerson) => $hioPerson->getObjectId(),
            $event->getHioHabilitation()->getPersons() ?? []
        );
        $this->eventDispatcher->dispatch(
            new AttachHioHabilitationToHioPersonsEvent(
                $hioHabilitationObjectId,
                $hioPersonObjectIds
            )
        );
    }
}
