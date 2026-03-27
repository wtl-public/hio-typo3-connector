<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioProjectsEvent;
use Wtl\HioTypo3Connector\Services\MmRelationService;

/** @see AttachHioPublicationToHioPersonsListener for the performance rationale. */
class AttachHioOrgUnitToHioProjectsListener
{
    private const OWNER_TABLE    = 'tx_hiotypo3connector_domain_model_orgunit';
    private const RELATED_TABLE  = 'tx_hiotypo3connector_domain_model_project';
    private const MM_TABLE       = 'tx_hiotypo3connector_orgunit_project_mm';
    private const COUNTER_COLUMN = 'projects';

    public function __construct(private readonly MmRelationService $mmRelationService) {}

    public function __invoke(AttachHioOrgUnitToHioProjectsEvent $event): void
    {
        $this->mmRelationService->syncRelationsOfOwner(
            ownerTable:         self::OWNER_TABLE,
            ownerObjectId:      $event->getHioOrgUnitObjectId(),
            relatedTable:       self::RELATED_TABLE,
            relatedObjectIds:   $event->getHioProjectObjectIds(),
            mmTable:            self::MM_TABLE,
            ownerCounterColumn: self::COUNTER_COLUMN,
        );
    }
}
