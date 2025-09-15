<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\HabilitationRepository;
use Wtl\HioTypo3Connector\Domain\Repository\OrgUnitRepository;
use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioHabilitationsEvent;

class AttachHioOrgUnitToHioHabilitationsListener
{
    public function __construct(
        protected readonly HabilitationRepository $habilitationRepository,
        protected readonly OrgUnitRepository          $orgUnitRepository,
        protected readonly PersistenceManager        $persistenceManager,
    )
    {
    }

    public function __invoke(AttachHioOrgUnitToHioHabilitationsEvent $event): void
    {
        $orgUnit = $this->orgUnitRepository->findByObjectId($event->getHioOrgUnitObjectId());
        if ($orgUnit === null) {
            return;
        }

        foreach ($event->getHioHabilitationObjectIds() as $hioHabilitationObjectId) {
            $habilitation = $this->habilitationRepository->findByObjectId($hioHabilitationObjectId);
            if ($habilitation === null) {
                continue;
            }
            $orgUnit->addHabilitation($habilitation);
            $this->orgUnitRepository->update($orgUnit);
            $this->persistenceManager->persistAll();
        }
    }
}
