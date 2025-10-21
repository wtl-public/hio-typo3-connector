<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\NominationRepository;
use Wtl\HioTypo3Connector\Domain\Repository\ProjectRepository;
use Wtl\HioTypo3Connector\Event\AttachHioNominationToHioProjectsEvent;

class AttachHioNominationToHioProjectsListener
{
    public function __construct(
        protected readonly ProjectRepository            $projectRepository,
        protected readonly NominationRepository           $nominationRepository,
        protected readonly PersistenceManager        $persistenceManager,
    )
    {
    }

    public function __invoke(AttachHioNominationToHioProjectsEvent $event): void
    {
        $nomination = $this->nominationRepository->findByObjectId($event->getHioNominationObjectId());
        if ($nomination === null) {
            return;
        }

        foreach ($event->getHioProjectObjectIds() as $hioProjectObjectId) {
            $project = $this->projectRepository->findByObjectId($hioProjectObjectId);
            if ($project === null) {
                continue;
            }
            $nomination->addProject($project);
            $this->nominationRepository->update($nomination);
            $this->persistenceManager->persistAll();
        }
    }
}
