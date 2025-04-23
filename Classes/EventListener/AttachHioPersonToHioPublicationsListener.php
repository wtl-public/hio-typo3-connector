<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\PersonRepository;
use Wtl\HioTypo3Connector\Domain\Repository\PublicationRepository;
use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioPublicationsEvent;

class AttachHioPersonToHioPublicationsListener
{
    public function __construct(
        protected readonly PublicationRepository $publicationRepository,
        protected readonly PersonRepository $personRepository,
        protected readonly PersistenceManager $persistenceManager,
    )
    {
    }

    public function __invoke(AttachHioPersonToHioPublicationsEvent $event): void
    {
        $person = $this->personRepository->findByObjectId($event->getHioPersonObjectId());
        if ($person === null) {
            return;
        }

        foreach ($event->getHioPublicationObjectIds() as $hioPublicationObjectId) {
            $publication = $this->publicationRepository->findByObjectId($hioPublicationObjectId);
            if ($publication === null) {
                continue;
            }

            // store the publication relation in the person
            $person->addPublication($publication);
            $this->personRepository->update($person);
            $this->persistenceManager->persistAll();
        }
    }
}
