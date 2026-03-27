<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\EventListener;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioProjectsEvent;
use Wtl\HioTypo3Connector\EventListener\AttachHioPersonToHioProjectsListener;
use Wtl\HioTypo3Connector\Services\MmRelationService;

final class AttachHioPersonToHioProjectsListenerTest extends UnitTestCase
{
    #[Test]
    public function invokeCallsSyncRelationsOfOwnerWithCorrectArguments(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService
            ->expects(self::once())
            ->method('syncRelationsOfOwner')
            ->with(
                'tx_hiotypo3connector_domain_model_person',
                7,
                'tx_hiotypo3connector_domain_model_project',
                [100, 200],
                'tx_hiotypo3connector_person_project_mm',
                'projects',
            );

        $event    = new AttachHioPersonToHioProjectsEvent(7, [100, 200]);
        $listener = new AttachHioPersonToHioProjectsListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeNeverCallsSyncOwnersOfRelated(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService->expects(self::never())->method('syncOwnersOfRelated');

        $listener = new AttachHioPersonToHioProjectsListener($mmRelationService);
        $listener(new AttachHioPersonToHioProjectsEvent(1, [2]));
    }
}

