<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Psr\EventDispatcher\EventDispatcherInterface;
use Wtl\HioTypo3Connector\Domain\Dto\PersonDto;
use Wtl\HioTypo3Connector\Domain\Repository\PersonRepository;
use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioDoctoralProgramsEvent;
use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioHabilitationsEvent;
use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioOrganizationsEvent;
use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioPatentsEvent;
use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioProjectsEvent;
use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioPublicationsEvent;
use Wtl\HioTypo3Connector\Event\ReceiveHioPersonEvent;

class ReceiveHioPersonListener
{
    public function __construct(
        protected readonly PersonRepository $personRepository,
        protected readonly EventDispatcherInterface $eventDispatcher
    )
    {
    }

    public function __invoke(ReceiveHioPersonEvent $event): void
    {
        $this->personRepository->save($event->getHioPerson(), $event->getStoragePid());

        $this->attachRelatedDoctoralPrograms($event->getHioPerson());
        $this->attachRelatedHabilitations($event->getHioPerson());
        $this->attachRelatedOrganizations($event->getHioPerson());
        $this->attachRelatedPatents($event->getHioPerson());
        $this->attachRelatedProjects($event->getHioPerson());
        $this->attachRelatedPublications($event->getHioPerson());
    }

    protected function attachRelatedDoctoralPrograms(PersonDto $personDto): void
    {
        $hioDoctoralProgramsObjectIds  = array_map(
            static fn($hioDoctoralProgram) => $hioDoctoralProgram->getId(),
            $personDto->getDoctoralPrograms() ?? []
        );
        $this->eventDispatcher->dispatch(
            new AttachHioPersonToHioDoctoralProgramsEvent(
                $personDto->getObjectId(),
                $hioDoctoralProgramsObjectIds
            )
        );
    }

    protected function attachRelatedHabilitations(PersonDto $hioPerson): void
    {
        $hioHabilitationObjectIds = array_map(
            static fn($hioHabilitation) => $hioHabilitation->getId(),
            $hioPerson->getHabilitations() ?? []
        );
        $this->eventDispatcher->dispatch(
            new AttachHioPersonToHioHabilitationsEvent(
                $hioPerson->getObjectId(),
                $hioHabilitationObjectIds
            )
        );
    }

    protected function attachRelatedOrganizations(PersonDto $hioPerson): void
    {
        $hioOrganizationObjectIds = array_map(
            static fn($hioOrganization) => $hioOrganization->getId(),
            $hioPerson->getOrganizations() ?? []
        );
        $this->eventDispatcher->dispatch(
            new AttachHioPersonToHioOrganizationsEvent(
                $hioPerson->getObjectId(),
                $hioOrganizationObjectIds
            )
        );
    }

    protected function attachRelatedPatents(PersonDto $personDto): void
    {
        $hioPatentObjectIds = array_map(
            static fn($hioPatent) => $hioPatent->getId(),
            $personDto->getPatents() ?? []
        );
        $this->eventDispatcher->dispatch(
            new AttachHioPersonToHioPatentsEvent(
                $personDto->getObjectId(),
                $hioPatentObjectIds
            )
        );
    }

    protected function attachRelatedProjects(PersonDto $hioPerson): void
    {
        $hioProjectObjectIds = array_map(
            static fn($hioProject) => $hioProject->getId(),
            $hioPerson->getProjects() ?? []
        );
        $this->eventDispatcher->dispatch(
            new AttachHioPersonToHioProjectsEvent(
                $hioPerson->getObjectId(),
                $hioProjectObjectIds
            )
        );
    }

    protected function attachRelatedPublications(PersonDto $hioPerson): void
    {
        $hioPersonObjectId  = $hioPerson->getObjectId();
        $hioPublicationObjectIds = array_map(
            static fn($hioPublication) => $hioPublication->getId(),
            $hioPerson->getPublications() ?? []
        );
        $this->eventDispatcher->dispatch(
            new AttachHioPersonToHioPublicationsEvent(
                $hioPersonObjectId,
                $hioPublicationObjectIds
            )
        );
    }
}
