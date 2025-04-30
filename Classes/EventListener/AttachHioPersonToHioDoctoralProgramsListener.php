<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\DoctoralProgramRepository;
use Wtl\HioTypo3Connector\Domain\Repository\PersonRepository;
use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioDoctoralProgramsEvent;

class AttachHioPersonToHioDoctoralProgramsListener
{
    public function __construct(
        protected readonly DoctoralProgramRepository $doctoralProgramRepository,
        protected readonly PersonRepository          $personRepository,
        protected readonly PersistenceManager        $persistenceManager,
    )
    {
    }

    public function __invoke(AttachHioPersonToHioDoctoralProgramsEvent $event): void
    {
        $person = $this->personRepository->findByObjectId($event->getHioPersonObjectId());
        if ($person === null) {
            return;
        }

        foreach ($event->getHioDoctoralProgramsObjectIds() as $hioDoctoralProgramsObjectId) {
            $doctoralProgram = $this->doctoralProgramRepository->findByObjectId($hioDoctoralProgramsObjectId);
            if ($doctoralProgram === null) {
                continue;
            }
            $person->addDoctoralProgram($doctoralProgram);
            $this->personRepository->update($person);
            $this->persistenceManager->persistAll();
        }
    }
}
