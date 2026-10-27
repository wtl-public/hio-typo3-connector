<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Services\RecordLifecycle;

use Symfony\Component\Console\Input\InputInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use Wtl\HioTypo3Connector\Services\HioApiService;

class RecordLifecycleService
{
    // Used with --with-trashed unless given explicitly, as in WTL's middleware test setup
    public const DEFAULT_SOFT_DELETE_AFTER_DAYS = 7;
    public const DEFAULT_HARD_DELETE_AFTER_DAYS = 30;

    public function __construct(private readonly ConnectionPool $connectionPool)
    {
    }

    public function startRun(HioApiService $apiService, string $table, InputInterface $input): RecordLifecycleRun
    {
        $withTrashed = (bool)$input->getOption('with-trashed');
        $softDeleteAfterDays = $this->getDays($input, 'soft-delete-after-days')
            ?? ($withTrashed ? self::DEFAULT_SOFT_DELETE_AFTER_DAYS : null);
        $hardDeleteAfterDays = $this->getDays($input, 'hard-delete-after-days')
            ?? ($withTrashed ? self::DEFAULT_HARD_DELETE_AFTER_DAYS : null);
        $apiService->setWithTrashed($withTrashed);

        return new RecordLifecycleRun(
            $this->connectionPool,
            $apiService,
            $table,
            (int)$input->getArgument('storagePageId'),
            $withTrashed,
            $softDeleteAfterDays,
            $hardDeleteAfterDays
        );
    }

    private function getDays(InputInterface $input, string $option): ?int
    {
        $days = (string)$input->getOption($option);
        if ($days === '') {
            return null;
        }
        if (!ctype_digit($days) || (int)$days < 1) {
            throw new \InvalidArgumentException(sprintf('--%s must be a whole number of days greater than 0', $option));
        }

        return (int)$days;
    }
}
