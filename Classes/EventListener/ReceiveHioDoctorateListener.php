<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Wtl\HioTypo3Connector\Domain\Repository\DoctorateRepository;
use Wtl\HioTypo3Connector\Event\ReceiveHioDoctorateEvent;

class ReceiveHioDoctorateListener
{
    protected ?DoctorateRepository $doctorateRepository = null;

    public function injectDoctorateRepository(DoctorateRepository $doctorateRepository): void
    {
        $this->doctorateRepository = $doctorateRepository;
    }
    public function __invoke(ReceiveHioDoctorateEvent $event): void
    {
        $this->doctorateRepository->save($event->getHioDoctorate(), $event->getStoragePid());
    }
}
