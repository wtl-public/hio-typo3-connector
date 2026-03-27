<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\EventListener;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Event\AttachHioProjectToHioPersonsEvent;
use Wtl\HioTypo3Connector\EventListener\AttachHioProjectToHioPersonsListener;
use Wtl\HioTypo3Connector\Services\MmRelationService;

final class AttachHioProjectToHioPersonsListenerTest extends UnitTestCase
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
                [6, 7, 8],
                'tx_hiotypo3connector_domain_model_project',
                150,
                'tx_hiotypo3connector_person_project_mm',
                'projects',
            );

        $event    = new AttachHioProjectToHioPersonsEvent(150, [6, 7, 8]);
        $listener = new AttachHioProjectToHioPersonsListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeNeverCallsSyncRelationsOfOwner(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService->expects(self::never())->method('syncRelationsOfOwner');

        $listener = new AttachHioProjectToHioPersonsListener($mmRelationService);
        $listener(new AttachHioProjectToHioPersonsEvent(1, [2]));
    }
}

