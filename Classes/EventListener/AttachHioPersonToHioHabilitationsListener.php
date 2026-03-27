<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioHabilitationsEvent;
use Wtl\HioTypo3Connector\Services\MmRelationService;

/** @see AttachHioPublicationToHioPersonsListener for the performance rationale. */
class AttachHioPersonToHioHabilitationsListener
{
    private const OWNER_TABLE    = 'tx_hiotypo3connector_domain_model_person';
    private const RELATED_TABLE  = 'tx_hiotypo3connector_domain_model_habilitation';
    private const MM_TABLE       = 'tx_hiotypo3connector_person_habilitation_mm';
    private const COUNTER_COLUMN = 'habilitations';

    public function __construct(private readonly MmRelationService $mmRelationService) {}

    public function __invoke(AttachHioPersonToHioHabilitationsEvent $event): void
    {
        $this->mmRelationService->syncRelationsOfOwner(
            ownerTable:         self::OWNER_TABLE,
            ownerObjectId:      $event->getHioPersonObjectId(),
            relatedTable:       self::RELATED_TABLE,
            relatedObjectIds:   $event->getHioHabilitationObjectIds(),
            mmTable:            self::MM_TABLE,
            ownerCounterColumn: self::COUNTER_COLUMN,
        );
    }
}
