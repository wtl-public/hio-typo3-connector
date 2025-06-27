<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\HabilitationRepository;
use Wtl\HioTypo3Connector\Domain\Repository\PersonRepository;
use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioHabilitationsEvent;

class AttachHioPersonToHioHabilitationsListener
{
    public function __construct(
        protected readonly HabilitationRepository $habilitationRepository,
        protected readonly PersonRepository $personRepository,
        protected readonly PersistenceManager $persistenceManager,
    )
    {
    }

    public function __invoke(AttachHioPersonToHioHabilitationsEvent $event): void
    {
        $person = $this->personRepository->findByObjectId($event->getHioPersonObjectId());
        if ($person === null) {
            return;
        }

        foreach ($event->getHioHabilitationObjectIds() as $hioHabilitationObjectId) {
            $habilitation = $this->habilitationRepository->findByObjectId($hioHabilitationObjectId);
            if ($habilitation === null) {
                continue;
            }
            $person->addHabilitation($habilitation);
            $this->personRepository->update($person);
            $this->persistenceManager->persistAll();
        }
    }
}
