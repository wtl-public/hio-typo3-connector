<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioPublicationsEvent;
use Wtl\HioTypo3Connector\Services\MmRelationService;

/** @see AttachHioPublicationToHioPersonsListener for the performance rationale. */
class AttachHioPersonToHioPublicationsListener
{
    private const OWNER_TABLE    = 'tx_hiotypo3connector_domain_model_person';
    private const RELATED_TABLE  = 'tx_hiotypo3connector_domain_model_publication';
    private const MM_TABLE       = 'tx_hiotypo3connector_person_publication_mm';
    private const COUNTER_COLUMN = 'publications';

    public function __construct(private readonly MmRelationService $mmRelationService) {}

    public function __invoke(AttachHioPersonToHioPublicationsEvent $event): void
    {
        $this->mmRelationService->syncRelationsOfOwner(
            ownerTable:         self::OWNER_TABLE,
            ownerObjectId:      $event->getHioPersonObjectId(),
            relatedTable:       self::RELATED_TABLE,
            relatedObjectIds:   $event->getHioPublicationObjectIds(),
            mmTable:            self::MM_TABLE,
            ownerCounterColumn: self::COUNTER_COLUMN,
        );
    }
}
