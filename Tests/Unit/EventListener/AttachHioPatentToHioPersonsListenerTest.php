<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\EventListener;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Event\AttachHioPatentToHioPersonsEvent;
use Wtl\HioTypo3Connector\EventListener\AttachHioPatentToHioPersonsListener;
use Wtl\HioTypo3Connector\Services\MmRelationService;

final class AttachHioPatentToHioPersonsListenerTest extends UnitTestCase
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
                [4, 5],
                'tx_hiotypo3connector_domain_model_patent',
                305,
                'tx_hiotypo3connector_person_patent_mm',
                'patents',
            );

        $event    = new AttachHioPatentToHioPersonsEvent(305, [4, 5]);
        $listener = new AttachHioPatentToHioPersonsListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeNeverCallsSyncRelationsOfOwner(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService->expects(self::never())->method('syncRelationsOfOwner');

        $listener = new AttachHioPatentToHioPersonsListener($mmRelationService);
        $listener(new AttachHioPatentToHioPersonsEvent(1, [2]));
    }
}

