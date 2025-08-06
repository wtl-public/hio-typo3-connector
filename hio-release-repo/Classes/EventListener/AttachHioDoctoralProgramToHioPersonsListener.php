<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\DoctoralProgramRepository;
use Wtl\HioTypo3Connector\Domain\Repository\PersonRepository;
use Wtl\HioTypo3Connector\Event\AttachHioDoctoralProgramToHioPersonsEvent;

class AttachHioDoctoralProgramToHioPersonsListener
{
    public function __construct(
        protected readonly DoctoralProgramRepository $doctoralProgramRepository,
        protected readonly PersonRepository          $personRepository,
        protected readonly PersistenceManager        $persistenceManager,
    )
    {
    }

    public function __invoke(AttachHioDoctoralProgramToHioPersonsEvent $event): void
    {
        $doctoralProgram = $this->doctoralProgramRepository->findByObjectId($event->getHioDoctoralProgramObjectId());
        if ($doctoralProgram === null) {
            return;
        }
        foreach ($event->getHioPersonObjectIds() as $hioPersonObjectId) {
            $person = $this->personRepository->findByObjectId($hioPersonObjectId);
            if ($person === null) {
                continue;
            }
            $person->addDoctoralProgram($doctoralProgram);
            $this->personRepository->update($person);
            $this->persistenceManager->persistAll();
        }
    }
}
