<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\HabilitationRepository;
use Wtl\HioTypo3Connector\Domain\Repository\OrgUnitRepository;
use Wtl\HioTypo3Connector\Domain\Repository\PersonRepository;
use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioHabilitationsEvent;
use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioOrganizationsEvent;

class AttachHioPersonToHioOrganizationsListener
{
    public function __construct(
        protected readonly OrgUnitRepository $organizationRepository,
        protected readonly PersonRepository $personRepository,
        protected readonly PersistenceManager $persistenceManager,
    )
    {
    }

    public function __invoke(AttachHioPersonToHioOrganizationsEvent $event): void
    {
        $person = $this->personRepository->findByObjectId($event->getHioPersonObjectId());
        if ($person === null) {
            return;
        }

        foreach ($event->getHioOrganizationsObjectIds() as $hioOrganizationObjectId) {
            $orgUnit = $this->organizationRepository->findByObjectId($hioOrganizationObjectId);
            if ($orgUnit === null) {
                continue;
            }
            $person->addOrganization($orgUnit);
            $this->personRepository->update($person);
            $this->persistenceManager->persistAll();
        }
    }
}
