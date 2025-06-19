<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Psr\EventDispatcher\EventDispatcherInterface;
use Wtl\HioTypo3Connector\Domain\Repository\DoctoralProgramRepository;
use Wtl\HioTypo3Connector\Event\AttachHioDoctoralProgramToHioPersonsEvent;
use Wtl\HioTypo3Connector\Event\ReceiveHioDoctoralProgramEvent;

class ReceiveHioDoctoralProgramListener
{
    public function __construct(
        protected readonly DoctoralProgramRepository $doctoralProgramRepository,
        protected readonly EventDispatcherInterface  $eventDispatcher
    )
    {
    }
    public function __invoke(ReceiveHioDoctoralProgramEvent $event): void
    {
        $this->doctoralProgramRepository->save($event->getHioDoctoralProgram(), $event->getStoragePid());
        $hioDoctoralProgramObjectId = $event->getHioDoctoralProgram()->getObjectId();
        $hioPersonObjectIds = array_map(
            static fn($hioPerson) => $hioPerson->getId(),
            $event->getHioDoctoralProgram()->getPersons() ?? []
        );
        $this->eventDispatcher->dispatch(
            new AttachHioDoctoralProgramToHioPersonsEvent(
                $hioDoctoralProgramObjectId,
                $hioPersonObjectIds
            )
        );
    }
}
