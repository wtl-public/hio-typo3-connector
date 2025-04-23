<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Psr\EventDispatcher\EventDispatcherInterface;
use Wtl\HioTypo3Connector\Domain\Repository\ProjectRepository;
use Wtl\HioTypo3Connector\Event\AttachHioProjectToHioPersonsEvent;
use Wtl\HioTypo3Connector\Event\ReceiveHioProjectEvent;

class ReceiveHioProjectListener
{
    public function __construct(
        protected readonly ProjectRepository $projectRepository,
        protected readonly EventDispatcherInterface $eventDispatcher
    )
    {
    }

    public function __invoke(ReceiveHioProjectEvent $event): void
    {
        $this->projectRepository->save($event->getHioProject(), $event->getStoragePid());
        $hioProjectObjectId = $event->getHioProject()->getObjectId();
        $hioPersonObjectIds = array_map(
            static fn($hioPerson) => $hioPerson->getObjectId(),
            $event->getHioProject()->getPersons() ?? []
        );
        $this->eventDispatcher->dispatch(
            new AttachHioProjectToHioPersonsEvent(
                $hioProjectObjectId,
                $hioPersonObjectIds
            )
        );
    }
}
