<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\PersonRepository;
use Wtl\HioTypo3Connector\Domain\Repository\ProjectRepository;
use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioProjectsEvent;

class AttachHioPersonToHioProjectsListener
{
    public function __construct(
        protected readonly ProjectRepository $projectRepository,
        protected readonly PersonRepository $personRepository,
        protected readonly PersistenceManager $persistenceManager,
    )
    {
    }

    public function __invoke(AttachHioPersonToHioProjectsEvent $event): void
    {
        $person = $this->personRepository->findByObjectId($event->getHioPersonObjectId());
        if ($person === null) {
            return;
        }

        foreach ($event->getHioProjectObjectIds() as $hioProjectObjectId) {
            $project = $this->projectRepository->findByObjectId($hioProjectObjectId);
            if ($project === null) {
                continue;
            }
            $person->addProject($project);
            $this->personRepository->update($person);
            $this->persistenceManager->persistAll();
        }
    }
}
