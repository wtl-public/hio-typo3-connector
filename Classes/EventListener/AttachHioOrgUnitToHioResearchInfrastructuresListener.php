<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioResearchInfrastructuresEvent;
use Wtl\HioTypo3Connector\Services\MmRelationService;

/** @see AttachHioPublicationToHioPersonsListener for the performance rationale. */
class AttachHioOrgUnitToHioResearchInfrastructuresListener
{
    private const OWNER_TABLE    = 'tx_hiotypo3connector_domain_model_orgunit';
    private const RELATED_TABLE  = 'tx_hiotypo3connector_domain_model_researchinfrastructure';
    private const MM_TABLE       = 'tx_hiotypo3connector_orgunit_researchinfrastructure_mm';
    private const COUNTER_COLUMN = 'research_infrastructures';

    public function __construct(private readonly MmRelationService $mmRelationService) {}

    public function __invoke(AttachHioOrgUnitToHioResearchInfrastructuresEvent $event): void
    {
        $this->mmRelationService->syncRelationsOfOwner(
            ownerTable:         self::OWNER_TABLE,
            ownerObjectId:      $event->getHioOrgUnitObjectId(),
            relatedTable:       self::RELATED_TABLE,
            relatedObjectIds:   $event->getHioResearchInfrastructureObjectIds(),
            mmTable:            self::MM_TABLE,
            ownerCounterColumn: self::COUNTER_COLUMN,
        );
    }
}
