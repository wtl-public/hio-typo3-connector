<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Psr\EventDispatcher\EventDispatcherInterface;
use Wtl\HioTypo3Connector\Domain\Dto\NominationDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnitDto;
use Wtl\HioTypo3Connector\Domain\Repository\NominationRepository;
use Wtl\HioTypo3Connector\Event\AttachHioNominationToHioOrgUnitsEvent;
use Wtl\HioTypo3Connector\Event\AttachHioNominationToHioPersonsEvent;
use Wtl\HioTypo3Connector\Event\AttachHioNominationToHioProjectsEvent;
use Wtl\HioTypo3Connector\Event\AttachHioNominationToHioPublicationsEvent;
use Wtl\HioTypo3Connector\Event\ReceiveHioNominationEvent;

class ReceiveHioNominationListener
{
    public function __construct(
        protected readonly NominationRepository $repository,
        protected readonly EventDispatcherInterface $eventDispatcher
    )
    {
    }

    public function __invoke(ReceiveHioNominationEvent $event): void
    {
        $this->repository->save($event->getHioNomination(), $event->getStoragePid());

        $this->attachRelatedNominees($event->getHioNomination());
        $this->attachRelatedOrgUnits($event->getHioNomination());
        $this->attachRelatedProjects($event->getHioNomination());
        $this->attachRelatedPublications($event->getHioNomination());
    }

    protected function attachRelatedNominees(NominationDto $dto): void
    {
        $personObjectIds  = array_map(
            static fn($hioNominee) => $hioNominee->getId(),
            $dto->getNominees() ?? []
        );

        $this->eventDispatcher->dispatch(
            new AttachHioNominationToHioPersonsEvent(
                $dto->getObjectId(),
                $personObjectIds
            )
        );
    }

    protected function attachRelatedOrgUnits(NominationDto $dto): void
    {
        $orgUnitObjectIds  = array_map(
            static fn($hioOrgUnit) => $hioOrgUnit->getId(),
            $dto->getOrgUnits() ?? []
        );

        $this->eventDispatcher->dispatch(
            new AttachHioNominationToHioOrgUnitsEvent(
                $dto->getObjectId(),
                $orgUnitObjectIds
            )
        );
    }

    protected function attachRelatedProjects(NominationDto $dto): void
    {
        $projectObjectIds  = array_map(
            static fn($hioProject) => $hioProject->getId(),
            $dto->getProjects() ?? []
        );

        $this->eventDispatcher->dispatch(
            new AttachHioNominationToHioProjectsEvent(
                $dto->getObjectId(),
                $projectObjectIds
            )
        );
    }

    protected function attachRelatedPublications(NominationDto $dto): void
    {
        $publicationObjectIds  = array_map(
            static fn($hioPublication) => $hioPublication->getId(),
            $dto->getPublications() ?? []
        );

        $this->eventDispatcher->dispatch(
            new AttachHioNominationToHioPublicationsEvent(
                $dto->getObjectId(),
                $publicationObjectIds
            )
        );
    }
}
