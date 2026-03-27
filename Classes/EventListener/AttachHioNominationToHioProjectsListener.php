<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Wtl\HioTypo3Connector\Event\AttachHioNominationToHioProjectsEvent;
use Wtl\HioTypo3Connector\Services\MmRelationService;

/** @see AttachHioPublicationToHioPersonsListener for the performance rationale. */
class AttachHioNominationToHioProjectsListener
{
    private const OWNER_TABLE    = 'tx_hiotypo3connector_domain_model_nomination';
    private const RELATED_TABLE  = 'tx_hiotypo3connector_domain_model_project';
    private const MM_TABLE       = 'tx_hiotypo3connector_nomination_project_mm';
    private const COUNTER_COLUMN = 'projects';

    public function __construct(private readonly MmRelationService $mmRelationService) {}

    public function __invoke(AttachHioNominationToHioProjectsEvent $event): void
    {
        $this->mmRelationService->syncRelationsOfOwner(
            ownerTable:         self::OWNER_TABLE,
            ownerObjectId:      $event->getHioNominationObjectId(),
            relatedTable:       self::RELATED_TABLE,
            relatedObjectIds:   $event->getHioProjectObjectIds(),
            mmTable:            self::MM_TABLE,
            ownerCounterColumn: self::COUNTER_COLUMN,
        );
    }
}
