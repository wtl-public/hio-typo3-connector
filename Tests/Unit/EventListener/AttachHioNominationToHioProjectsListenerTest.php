<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\EventListener;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Event\AttachHioNominationToHioProjectsEvent;
use Wtl\HioTypo3Connector\EventListener\AttachHioNominationToHioProjectsListener;
use Wtl\HioTypo3Connector\Services\MmRelationService;

final class AttachHioNominationToHioProjectsListenerTest extends UnitTestCase
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
                25,
                'tx_hiotypo3connector_domain_model_project',
                [130, 140],
                'tx_hiotypo3connector_nomination_project_mm',
                'projects',
            );

        $event    = new AttachHioNominationToHioProjectsEvent(25, [130, 140]);
        $listener = new AttachHioNominationToHioProjectsListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeNeverCallsSyncOwnersOfRelated(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService->expects(self::never())->method('syncOwnersOfRelated');

        $listener = new AttachHioNominationToHioProjectsListener($mmRelationService);
        $listener(new AttachHioNominationToHioProjectsEvent(1, [2]));
    }
}

