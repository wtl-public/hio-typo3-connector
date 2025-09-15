<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Psr\EventDispatcher\EventDispatcherInterface;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnitDto;
use Wtl\HioTypo3Connector\Domain\Repository\OrgUnitRepository;
use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioDoctoralProgramsEvent;
use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioHabilitationsEvent;
use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioPatentsEvent;
use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioProjectsEvent;
use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioPublicationsEvent;
use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioResearchInfrastructuresEvent;
use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioSpinOffsEvent;
use Wtl\HioTypo3Connector\Event\ReceiveHioOrgUnitEvent;

class ReceiveHioOrgUnitListener
{
    public function __construct(
        protected readonly OrgUnitRepository $repository,
        protected readonly EventDispatcherInterface $eventDispatcher
    )
    {
    }

    public function __invoke(ReceiveHioOrgUnitEvent $event): void
    {
        $this->repository->save($event->getHioOrgUnit(), $event->getStoragePid());

        $this->attachRelatedDoctoralPrograms($event->getHioOrgUnit());
        $this->attachRelatedHabilitations($event->getHioOrgUnit());
        $this->attachRelatedPatents($event->getHioOrgUnit());
        $this->attachRelatedProjects($event->getHioOrgUnit());
        $this->attachRelatedPublications($event->getHioOrgUnit());
        $this->attachRelatedResearchInfrastructures($event->getHioOrgUnit());
        $this->attachRelatedSpinOffs($event->getHioOrgUnit());
    }

    protected function attachRelatedDoctoralPrograms(OrgUnitDto $hioOrgUnitDto): void
    {
        $doctoralProgramsObjectIds  = array_map(
            static fn($hioDoctoralProgram) => $hioDoctoralProgram->getId(),
            $hioOrgUnitDto->getDoctoralPrograms() ?? []
        );

        $this->eventDispatcher->dispatch(
            new AttachHioOrgUnitToHioDoctoralProgramsEvent(
                $hioOrgUnitDto->getObjectId(),
                $doctoralProgramsObjectIds
            )
        );
    }

    protected function attachRelatedHabilitations(OrgUnitDto $hioOrgUnitDto): void
    {
        $habilitationObjectIds  = array_map(
            static fn($hioHabilitation) => $hioHabilitation->getId(),
            $hioOrgUnitDto->getHabilitations() ?? []
        );

        $this->eventDispatcher->dispatch(
            new AttachHioOrgUnitToHioHabilitationsEvent(
                $hioOrgUnitDto->getObjectId(),
                $habilitationObjectIds
            )
        );
    }

    protected function attachRelatedPatents(OrgUnitDto $hioOrgUnitDto): void
    {
        $patentObjectIds  = array_map(
            static fn($hioPatent) => $hioPatent->getId(),
            $hioOrgUnitDto->getPatents() ?? []
        );

        $this->eventDispatcher->dispatch(
            new AttachHioOrgUnitToHioPatentsEvent(
                $hioOrgUnitDto->getObjectId(),
                $patentObjectIds
            )
        );
    }

    protected function attachRelatedProjects(OrgUnitDto $hioOrgUnitDto): void
    {
        $projectObjectIds  = array_map(
            static fn($hioProject) => $hioProject->getId(),
            $hioOrgUnitDto->getProjects() ?? []
        );

        $this->eventDispatcher->dispatch(
            new AttachHioOrgUnitToHioProjectsEvent(
                $hioOrgUnitDto->getObjectId(),
                $projectObjectIds
            )
        );
    }

    protected function attachRelatedPublications(OrgUnitDto $hioOrgUnitDto): void
    {
        $publicationObjectIds  = array_map(
            static fn($hioPublication) => $hioPublication->getId(),
            $hioOrgUnitDto->getPublications() ?? []
        );

        $this->eventDispatcher->dispatch(
            new AttachHioOrgUnitToHioPublicationsEvent(
                $hioOrgUnitDto->getObjectId(),
                $publicationObjectIds
            )
        );
    }

    protected function attachRelatedResearchInfrastructures(OrgUnitDto $hioOrgUnitDto): void
    {
        $researchInfrastructureObjectIds  = array_map(
            static fn($hioResearchInfrastructure) => $hioResearchInfrastructure->getId(),
            $hioOrgUnitDto->getResearchInfrastructures() ?? []
        );

        $this->eventDispatcher->dispatch(
            new AttachHioOrgUnitToHioResearchInfrastructuresEvent(
                $hioOrgUnitDto->getObjectId(),
                $researchInfrastructureObjectIds
            )
        );
    }

    protected function attachRelatedSpinOffs(OrgUnitDto $hioOrgUnitDto): void
    {
        $spinOffObjectIds  = array_map(
            static fn($hioSpinOff) => $hioSpinOff->getId(),
            $hioOrgUnitDto->getSpinOffs() ?? []
        );

        $this->eventDispatcher->dispatch(
            new AttachHioOrgUnitToHioSpinOffsEvent(
                $hioOrgUnitDto->getObjectId(),
                $spinOffObjectIds
            )
        );
    }
}
