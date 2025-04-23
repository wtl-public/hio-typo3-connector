<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\DoctorateRepository;
use Wtl\HioTypo3Connector\Domain\Repository\PersonRepository;
use Wtl\HioTypo3Connector\Event\AttachHioDoctorateToHioPersonsEvent;

class AttachHioDoctorateToHioPersonsListener
{
    public function __construct(
        protected readonly DoctorateRepository $doctorateRepository,
        protected readonly PersonRepository $personRepository,
        protected readonly PersistenceManager $persistenceManager,
    )
    {
    }

    public function __invoke(AttachHioDoctorateToHioPersonsEvent $event): void
    {
        $doctorate = $this->doctorateRepository->findByObjectId($event->getHioDoctorateObjectId());
        if ($doctorate === null) {
            return;
        }
        foreach ($event->getHioPersonObjectIds() as $hioPersonObjectId) {
            $person = $this->personRepository->findByObjectId($hioPersonObjectId);
            if ($person === null) {
                continue;
            }
            $person->addDoctorate($doctorate);
            $this->personRepository->update($person);
            $this->persistenceManager->persistAll();
        }
    }
}
