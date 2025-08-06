<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\PatentRepository;
use Wtl\HioTypo3Connector\Domain\Repository\PersonRepository;
use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioPatentsEvent;

class AttachHioPersonToHioPatentsListener
{
    public function __construct(
        protected readonly PatentRepository $patentRepository,
        protected readonly PersonRepository $personRepository,
        protected readonly PersistenceManager $persistenceManager,
    )
    {
    }

    public function __invoke(AttachHioPersonToHioPatentsEvent $event): void
    {
        $person = $this->personRepository->findByObjectId($event->getHioPersonObjectId());
        if ($person === null) {
            return;
        }

        foreach ($event->getHioPatentObjectIds() as $hioPatentObjectId) {
            $patent = $this->patentRepository->findByObjectId($hioPatentObjectId);
            if ($patent === null) {
                continue;
            }
            $person->addPatent($patent);
            $this->personRepository->update($person);
            $this->persistenceManager->persistAll();
        }
    }
}
