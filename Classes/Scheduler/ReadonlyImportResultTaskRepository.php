<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Scheduler;

use TYPO3\CMS\Scheduler\Domain\Repository\SchedulerTaskRepository;

final readonly class ReadonlyImportResultTaskRepository extends SchedulerTaskRepository
{
    use WithImportResultTaskRepositoryTrait;
}
