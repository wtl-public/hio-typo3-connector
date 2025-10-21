<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\NominationRepository;
use Wtl\HioTypo3Connector\Domain\Repository\PersonRepository;
use Wtl\HioTypo3Connector\Event\AttachHioNominationToHioPersonsEvent;

class AttachHioNominationToHioPersonsListener
{
    public function __construct(
        protected readonly NominationRepository $nominationRepository,
        protected readonly PersonRepository $personRepository,
        protected readonly PersistenceManager $persistenceManager,
    )
    {
    }
    public function __invoke(AttachHioNominationToHioPersonsEvent $event): void
    {
        $nomination = $this->nominationRepository->findByObjectId($event->getHioNominationObjectId());
        if ($nomination === null) {
            return;
        }

        foreach ($event->getHioPersonObjectIds() as $hioPersonObjectId) {
            $person = $this->personRepository->findByObjectId($hioPersonObjectId);
            if ($person === null) {
                continue;
            }
            $nomination->addNominee($person);
            $this->nominationRepository->update($nomination);
            $this->persistenceManager->persistAll();
        }
    }
}
