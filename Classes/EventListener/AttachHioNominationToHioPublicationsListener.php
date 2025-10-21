<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\NominationRepository;
use Wtl\HioTypo3Connector\Domain\Repository\PublicationRepository;
use Wtl\HioTypo3Connector\Event\AttachHioNominationToHioPublicationsEvent;

class AttachHioNominationToHioPublicationsListener
{
    public function __construct(
        protected readonly PublicationRepository            $publicationRepository,
        protected readonly NominationRepository           $nominationRepository,
        protected readonly PersistenceManager        $persistenceManager,
    )
    {
    }

    public function __invoke(AttachHioNominationToHioPublicationsEvent $event): void
    {
        $nomination = $this->nominationRepository->findByObjectId($event->getHioNominationObjectId());
        if ($nomination === null) {
            return;
        }

        foreach ($event->getHioPublicationObjectIds() as $hioPublicationObjectId) {
            $publication = $this->publicationRepository->findByObjectId($hioPublicationObjectId);
            if ($publication === null) {
                continue;
            }
            $nomination->addPublication($publication);
            $this->nominationRepository->update($nomination);
            $this->persistenceManager->persistAll();
        }
    }
}
