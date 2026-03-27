<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Wtl\HioTypo3Connector\Event\AttachHioPatentToHioPersonsEvent;
use Wtl\HioTypo3Connector\Services\MmRelationService;

/** @see AttachHioPublicationToHioPersonsListener for the performance rationale. */
class AttachHioPatentToHioPersonsListener
{
    private const OWNER_TABLE    = 'tx_hiotypo3connector_domain_model_person';
    private const RELATED_TABLE  = 'tx_hiotypo3connector_domain_model_patent';
    private const MM_TABLE       = 'tx_hiotypo3connector_person_patent_mm';
    private const COUNTER_COLUMN = 'patents';

    public function __construct(private readonly MmRelationService $mmRelationService) {}

    public function __invoke(AttachHioPatentToHioPersonsEvent $event): void
    {
        $this->mmRelationService->syncOwnersOfRelated(
            ownerTable:         self::OWNER_TABLE,
            ownerObjectIds:     $event->getHioPersonObjectIds(),
            relatedTable:       self::RELATED_TABLE,
            relatedObjectId:    $event->getHioPatentObjectId(),
            mmTable:            self::MM_TABLE,
            ownerCounterColumn: self::COUNTER_COLUMN,
        );
    }
}
