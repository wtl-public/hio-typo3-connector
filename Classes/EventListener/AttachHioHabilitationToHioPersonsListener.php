<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\HabilitationRepository;
use Wtl\HioTypo3Connector\Domain\Repository\PersonRepository;
use Wtl\HioTypo3Connector\Event\AttachHioHabilitationToHioPersonsEvent;

class AttachHioHabilitationToHioPersonsListener
{
    public function __construct(
        protected readonly HabilitationRepository $habilitationRepository,
        protected readonly PersonRepository $personRepository,
        protected readonly PersistenceManager $persistenceManager,
    )
    {
    }
    public function __invoke(AttachHioHabilitationToHioPersonsEvent $event): void
    {
        $habilitation = $this->habilitationRepository->findByObjectId($event->getHioHabilitationObjectId());
        if ($habilitation === null) {
            return;
        }

        foreach ($event->getHioPersonObjectIds() as $hioPersonObjectId) {
            $person = $this->personRepository->findByObjectId($hioPersonObjectId);
            if ($person === null) {
                continue;
            }
            $person->addHabilitation($habilitation);
            $this->personRepository->update($person);
            $this->persistenceManager->persistAll();
        }
    }
}
