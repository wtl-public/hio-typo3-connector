<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Psr\EventDispatcher\EventDispatcherInterface;
use Wtl\HioTypo3Connector\Domain\Repository\DoctorateRepository;
use Wtl\HioTypo3Connector\Event\AttachHioDoctorateToHioPersonsEvent;
use Wtl\HioTypo3Connector\Event\ReceiveHioDoctorateEvent;

class ReceiveHioDoctorateListener
{
    public function __construct(
        protected readonly DoctorateRepository $doctorateRepository,
        protected readonly EventDispatcherInterface $eventDispatcher
    )
    {
    }
    public function __invoke(ReceiveHioDoctorateEvent $event): void
    {
        $this->doctorateRepository->save($event->getHioDoctorate(), $event->getStoragePid());
        $hioDoctorateObjectId = $event->getHioDoctorate()->getObjectId();
        $hioPersonObjectIds = array_map(
            static fn($hioPerson) => $hioPerson->getObjectId(),
            $event->getHioDoctorate()->getPersons() ?? []
        );
        $this->eventDispatcher->dispatch(
            new AttachHioDoctorateToHioPersonsEvent(
                $hioDoctorateObjectId,
                $hioPersonObjectIds
            )
        );
    }
}
