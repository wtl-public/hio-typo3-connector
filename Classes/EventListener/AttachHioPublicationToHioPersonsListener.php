<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\PersonRepository;
use Wtl\HioTypo3Connector\Domain\Repository\PublicationRepository;
use Wtl\HioTypo3Connector\Event\AttachHioPublicationToHioPersonsEvent;

class AttachHioPublicationToHioPersonsListener
{
    public function __construct(
        protected readonly PublicationRepository $publicationRepository,
        protected readonly PersonRepository $personRepository,
        protected readonly PersistenceManager $persistenceManager,
    )
    {
    }
    public function __invoke(AttachHioPublicationToHioPersonsEvent $event): void
    {
        $publication = $this->publicationRepository->findByObjectId($event->getHioPublicationObjectId());
        if ($publication === null) {
            return;
        }

        foreach ($event->getHioPersonObjectIds() as $hioPersonObjectId) {
            $person = $this->personRepository->findByObjectId($hioPersonObjectId);
            if ($person === null) {
                continue;
            }
            $person->addPublication($publication);
            $this->personRepository->update($person);
            $this->persistenceManager->persistAll();
        }
    }
}
