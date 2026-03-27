<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\EventListener;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Event\AttachHioPublicationToHioPersonsEvent;
use Wtl\HioTypo3Connector\EventListener\AttachHioPublicationToHioPersonsListener;
use Wtl\HioTypo3Connector\Services\MmRelationService;

final class AttachHioPublicationToHioPersonsListenerTest extends UnitTestCase
{
    #[Test]
    public function invokeCallsSyncOwnersOfRelatedWithCorrectArguments(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService
            ->expects(self::once())
            ->method('syncOwnersOfRelated')
            ->with(
                'tx_hiotypo3connector_domain_model_person',
                [1, 2, 3],
                'tx_hiotypo3connector_domain_model_publication',
                99,
                'tx_hiotypo3connector_person_publication_mm',
                'publications',
            );

        $event    = new AttachHioPublicationToHioPersonsEvent(99, [1, 2, 3]);
        $listener = new AttachHioPublicationToHioPersonsListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeCallsSyncOwnersOfRelatedWithEmptyOwnerIds(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService
            ->expects(self::once())
            ->method('syncOwnersOfRelated')
            ->with(
                'tx_hiotypo3connector_domain_model_person',
                [],
                'tx_hiotypo3connector_domain_model_publication',
                99,
                'tx_hiotypo3connector_person_publication_mm',
                'publications',
            );

        $event    = new AttachHioPublicationToHioPersonsEvent(99, []);
        $listener = new AttachHioPublicationToHioPersonsListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeNeverCallsSyncRelationsOfOwner(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService->expects(self::never())->method('syncRelationsOfOwner');

        $listener = new AttachHioPublicationToHioPersonsListener($mmRelationService);
        $listener(new AttachHioPublicationToHioPersonsEvent(1, [2]));
    }
}

