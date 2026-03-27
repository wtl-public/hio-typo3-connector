<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Wtl\HioTypo3Connector\Event\AttachHioNominationToHioOrgUnitsEvent;
use Wtl\HioTypo3Connector\Services\MmRelationService;

/** @see AttachHioPublicationToHioPersonsListener for the performance rationale. */
class AttachHioNominationToHioOrgUnitsListener
{
    private const OWNER_TABLE    = 'tx_hiotypo3connector_domain_model_nomination';
    private const RELATED_TABLE  = 'tx_hiotypo3connector_domain_model_orgunit';
    private const MM_TABLE       = 'tx_hiotypo3connector_nomination_orgunit_mm';
    private const COUNTER_COLUMN = 'org_units';

    public function __construct(private readonly MmRelationService $mmRelationService) {}

    public function __invoke(AttachHioNominationToHioOrgUnitsEvent $event): void
    {
        $this->mmRelationService->syncRelationsOfOwner(
            ownerTable:         self::OWNER_TABLE,
            ownerObjectId:      $event->getHioNominationObjectId(),
            relatedTable:       self::RELATED_TABLE,
            relatedObjectIds:   $event->getHioOrgUnitObjectIds(),
            mmTable:            self::MM_TABLE,
            ownerCounterColumn: self::COUNTER_COLUMN,
        );
    }
}
