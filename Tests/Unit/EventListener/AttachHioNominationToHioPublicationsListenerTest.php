<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\EventListener;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Event\AttachHioNominationToHioPublicationsEvent;
use Wtl\HioTypo3Connector\EventListener\AttachHioNominationToHioPublicationsListener;
use Wtl\HioTypo3Connector\Services\MmRelationService;

final class AttachHioNominationToHioPublicationsListenerTest extends UnitTestCase
{
    #[Test]
    public function invokeCallsSyncRelationsOfOwnerWithCorrectArguments(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService
            ->expects(self::once())
            ->method('syncRelationsOfOwner')
            ->with(
                'tx_hiotypo3connector_domain_model_nomination',
                35,
                'tx_hiotypo3connector_domain_model_publication',
                [210, 220, 230],
                'tx_hiotypo3connector_nomination_publication_mm',
                'publications',
            );

        $event    = new AttachHioNominationToHioPublicationsEvent(35, [210, 220, 230]);
        $listener = new AttachHioNominationToHioPublicationsListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeNeverCallsSyncOwnersOfRelated(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService->expects(self::never())->method('syncOwnersOfRelated');

        $listener = new AttachHioNominationToHioPublicationsListener($mmRelationService);
        $listener(new AttachHioNominationToHioPublicationsEvent(1, [2]));
    }
}

