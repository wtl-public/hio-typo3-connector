<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Psr\EventDispatcher\EventDispatcherInterface;
use Wtl\HioTypo3Connector\Domain\Repository\PublicationRepository;
use Wtl\HioTypo3Connector\Event\AttachHioPublicationToHioPersonsEvent;
use Wtl\HioTypo3Connector\Event\ReceiveHioPublicationEvent;

class ReceiveHioPublicationListener
{
    public function __construct(
        protected readonly PublicationRepository $publicationRepository,
        protected readonly EventDispatcherInterface $eventDispatcher
    )
    {
    }
    public function __invoke(ReceiveHioPublicationEvent $event): void
    {
        $this->publicationRepository->save($event->getHioPublication(), $event->getStoragePid());
        $hioPublicationObjectId = $event->getHioPublication()->getObjectId();
        $hioPersonObjectIds = [];
        foreach ($event->getHioPublication()->getPersons() as $hioPerson) {
            if ($hioPerson->getId() === null) {
                continue;
            }
            $hioPersonObjectIds[] = $hioPerson->getId();
        }
        $this->eventDispatcher->dispatch(new AttachHioPublicationToHioPersonsEvent(
            $hioPublicationObjectId,
            $hioPersonObjectIds
        ));
    }
}
