<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioPatentsEvent;
use Wtl\HioTypo3Connector\Services\MmRelationService;

/** @see AttachHioPublicationToHioPersonsListener for the performance rationale. */
class AttachHioOrgUnitToHioPatentsListener
{
    private const OWNER_TABLE    = 'tx_hiotypo3connector_domain_model_orgunit';
    private const RELATED_TABLE  = 'tx_hiotypo3connector_domain_model_patent';
    private const MM_TABLE       = 'tx_hiotypo3connector_orgunit_patent_mm';
    private const COUNTER_COLUMN = 'patents';

    public function __construct(private readonly MmRelationService $mmRelationService) {}

    public function __invoke(AttachHioOrgUnitToHioPatentsEvent $event): void
    {
        $this->mmRelationService->syncRelationsOfOwner(
            ownerTable:         self::OWNER_TABLE,
            ownerObjectId:      $event->getHioOrgUnitObjectId(),
            relatedTable:       self::RELATED_TABLE,
            relatedObjectIds:   $event->getHioPatentObjectIds(),
            mmTable:            self::MM_TABLE,
            ownerCounterColumn: self::COUNTER_COLUMN,
        );
    }
}
