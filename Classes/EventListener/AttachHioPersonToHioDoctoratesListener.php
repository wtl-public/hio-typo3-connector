<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\DoctorateRepository;
use Wtl\HioTypo3Connector\Domain\Repository\PersonRepository;
use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioDoctoratesEvent;

class AttachHioPersonToHioDoctoratesListener
{
    public function __construct(
        protected readonly DoctorateRepository $doctorateRepository,
        protected readonly PersonRepository $personRepository,
        protected readonly PersistenceManager $persistenceManager,
    )
    {
    }

    public function __invoke(AttachHioPersonToHioDoctoratesEvent $event): void
    {
        $person = $this->personRepository->findByObjectId($event->getHioPersonObjectId());
        if ($person === null) {
            return;
        }

        foreach ($event->getHioDoctorateObjectIds() as $hioDoctorateObjectId) {
            $doctorate = $this->doctorateRepository->findByObjectId($hioDoctorateObjectId);
            if ($doctorate === null) {
                continue;
            }
            $person->addDoctorate($doctorate);
            $this->personRepository->update($person);
            $this->persistenceManager->persistAll();
        }
    }
}
