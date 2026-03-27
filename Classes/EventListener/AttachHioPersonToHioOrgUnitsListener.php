<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioOrgUnitsEvent;
use Wtl\HioTypo3Connector\Services\MmRelationService;

/** @see AttachHioPublicationToHioPersonsListener for the performance rationale. */
class AttachHioPersonToHioOrgUnitsListener
{
    private const OWNER_TABLE    = 'tx_hiotypo3connector_domain_model_person';
    private const RELATED_TABLE  = 'tx_hiotypo3connector_domain_model_orgunit';
    private const MM_TABLE       = 'tx_hiotypo3connector_person_orgunit_mm';
    private const COUNTER_COLUMN = 'org_units';

    public function __construct(private readonly MmRelationService $mmRelationService) {}

    public function __invoke(AttachHioPersonToHioOrgUnitsEvent $event): void
    {
        $this->mmRelationService->syncRelationsOfOwner(
            ownerTable:         self::OWNER_TABLE,
            ownerObjectId:      $event->getHioPersonObjectId(),
            relatedTable:       self::RELATED_TABLE,
            relatedObjectIds:   $event->getHioOrgUnitObjectIds(),
            mmTable:            self::MM_TABLE,
            ownerCounterColumn: self::COUNTER_COLUMN,
        );
    }
}
