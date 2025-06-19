<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\PersonRepository;
use Wtl\HioTypo3Connector\Domain\Repository\ProjectRepository;
use Wtl\HioTypo3Connector\Event\AttachHioProjectToHioPersonsEvent;

class AttachHioProjectToHioPersonsListener
{
    public function __construct(
        protected readonly ProjectRepository $projectRepository,
        protected readonly PersonRepository $personRepository,
        protected readonly PersistenceManager $persistenceManager,
    )
    {
    }
    public function __invoke(AttachHioProjectToHioPersonsEvent $event): void
    {
        $project = $this->projectRepository->findByObjectId($event->getHioProjectObjectId());
        if ($project === null) {
            return;
        }

        foreach ($event->getHioPersonObjectIds() as $hioPersonObjectId) {
            $person = $this->personRepository->findByObjectId($hioPersonObjectId);
            if ($person === null) {
                continue;
            }
            $person->addProject($project);
            $this->personRepository->update($person);
            $this->persistenceManager->persistAll();
        }
    }
}
