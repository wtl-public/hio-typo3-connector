<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Services\RecordLifecycle;

use Doctrine\DBAL\ArrayParameterType;
use Doctrine\DBAL\ParameterType;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use Wtl\HioTypo3Connector\Services\HioApiService;

/**
 * Keeps the records of one import run's storage folder in line with the HIO middleware: hides
 * (soft delete, hidden=1) the ones it reports as trashed or no longer receives from HISinOne,
 * shows them again once delivered as live and moves them to the recycle bin (hard delete,
 * deleted=1) after a retention period. Only records the import hid (soft_deleted_at > 0) are
 * ever shown again or hard deleted.
 */
class RecordLifecycleRun
{
    private const DAY = 86400;

    private int $restored = 0;

    private int $softDeleted = 0;

    private int $hardDeleted = 0;

    /** Delivered records that were not imported: trashed ones and ones that stay deleted */
    private int $notImported = 0;

    /** Newest lastSeenAt/deletedAt of the run, never "now": a stalled middleware sync must not age records out */
    private ?int $referenceTime = null;

    public function __construct(
        private readonly ConnectionPool $connectionPool,
        private readonly HioApiService $apiService,
        private readonly string $table,
        private readonly int $storagePageId,
        private readonly bool $withTrashed,
        private readonly ?int $softDeleteAfterDays,
        private readonly ?int $hardDeleteAfterDays
    ) {
    }

    /**
     * Call for each page before its records are dispatched; returns the records to dispatch.
     *
     * @param object[] $records DTOs with getObjectId()
     * @return object[]
     */
    public function beforeDispatch(array $records): array
    {
        $page = $this->apiService->getResponse();
        $lastSeen = $page->getLastSeen();
        $trashed = $page->getTrashed();
        $timestamps = array_filter([...$lastSeen, ...$trashed]);
        if ($timestamps !== []) {
            $this->referenceTime = max($this->referenceTime ?? 0, ...$timestamps);
        }

        if ($this->withTrashed) {
            foreach ($this->groupByTimestamp($trashed, time()) as $deletedAt => $objectIds) {
                $this->softDeleteTrashed($objectIds, $deletedAt);
            }
        }

        $stillDeleted = $this->restoreDelivered($lastSeen);
        $toDispatch = array_values(array_filter(
            $records,
            static fn(object $record): bool => !isset($stillDeleted[$record->getObjectId()])
        ));
        $this->notImported += count($trashed) + count($records) - count($toDispatch);

        return $toDispatch;
    }

    /**
     * Call for each page after its records are dispatched, so new records get last_seen_at too.
     */
    public function afterDispatch(): void
    {
        if ($this->referenceTime === null) {
            return;
        }
        // Like in restoreDelivered(), a record without lastSeenAt counts as seen now
        $lastSeen = $this->groupByTimestamp($this->apiService->getResponse()->getLastSeen(), $this->referenceTime);
        foreach ($lastSeen as $lastSeenAt => $objectIds) {
            $this->updateQuery($objectIds)->set('last_seen_at', $lastSeenAt)->executeStatement();
        }
    }

    /**
     * Call once after the last page has been dispatched; writes the run's summary.
     *
     * @param string $label plural name of the imported records, e.g. 'Projects'
     */
    public function finish(OutputInterface $output, string $label): void
    {
        if ($this->referenceTime !== null) {
            $this->setMissingLastSeen($this->referenceTime);
            if ($this->softDeleteAfterDays !== null) {
                $this->softDeleteStale($this->referenceTime - $this->softDeleteAfterDays * self::DAY);
            }
            if ($this->hardDeleteAfterDays !== null) {
                $this->hardDelete($this->referenceTime - $this->hardDeleteAfterDays * self::DAY);
            }
        }

        $output->writeln(sprintf(
            '%d %s imported successfully%s',
            $this->apiService->getMeta()->getTotal() - $this->notImported,
            $label,
            $this->restored > 0 ? sprintf(' (%d restored)', $this->restored) : ''
        ));
        if ($this->softDeleteAfterDays !== null) {
            $output->writeln(sprintf('%d %s soft deleted successfully', $this->softDeleted, $label));
        }
        if ($this->hardDeleteAfterDays !== null) {
            $output->writeln(sprintf('%d %s hard deleted successfully', $this->hardDeleted, $label));
        }
    }

    /**
     * Records that vanished from the middleware before it reported lastSeenAt start ageing now.
     */
    private function setMissingLastSeen(int $referenceTime): void
    {
        $queryBuilder = $this->updateQuery();
        $queryBuilder
            ->set('last_seen_at', $referenceTime)
            ->andWhere(
                $queryBuilder->expr()->eq('last_seen_at', $queryBuilder->createNamedParameter(0, ParameterType::INTEGER))
            )
            ->executeStatement();
    }

    private function softDeleteStale(int $staleBefore): void
    {
        $queryBuilder = $this->softDeleteQuery();
        $this->softDeleted += $queryBuilder
            ->set(
                'soft_deleted_at',
                $queryBuilder->quoteIdentifier('last_seen_at') . ' + ' . $this->softDeleteAfterDays * self::DAY,
                false
            )
            ->andWhere(
                $queryBuilder->expr()->gt('last_seen_at', $queryBuilder->createNamedParameter(0, ParameterType::INTEGER)),
                $queryBuilder->expr()->lt('last_seen_at', $queryBuilder->createNamedParameter($staleBefore, ParameterType::INTEGER))
            )
            ->executeStatement();
    }

    /**
     * tstamp records the deletion time, so cleanup:deletedrecords --min-age can purge by age.
     */
    private function hardDelete(int $softDeletedBefore): void
    {
        $queryBuilder = $this->updateQuery();
        $this->hardDeleted += $queryBuilder
            ->set('deleted', 1)
            ->set('tstamp', time())
            ->andWhere(
                $queryBuilder->expr()->eq('hidden', $queryBuilder->createNamedParameter(1, ParameterType::INTEGER)),
                $queryBuilder->expr()->gt('soft_deleted_at', $queryBuilder->createNamedParameter(0, ParameterType::INTEGER)),
                $queryBuilder->expr()->lt('soft_deleted_at', $queryBuilder->createNamedParameter($softDeletedBefore, ParameterType::INTEGER))
            )
            ->executeStatement();
    }

    /**
     * @param int[] $objectIds
     */
    private function softDeleteTrashed(array $objectIds, int $deletedAt): void
    {
        $this->softDeleted += $this->softDeleteQuery($objectIds)
            ->set('soft_deleted_at', $deletedAt)
            ->executeStatement();
    }

    /**
     * Soft delete of visible records; records an editor hid stay as they are.
     *
     * @param int[]|null $objectIds
     */
    private function softDeleteQuery(?array $objectIds = null): QueryBuilder
    {
        $queryBuilder = $this->updateQuery($objectIds);

        return $queryBuilder
            ->set('hidden', 1)
            ->set('tstamp', time())
            ->andWhere($queryBuilder->expr()->eq('hidden', $queryBuilder->createNamedParameter(0, ParameterType::INTEGER)));
    }

    /**
     * UPDATE of the records in the run's storage folder (optionally only the given ones),
     * never touching hard deleted ones.
     *
     * @param int[]|null $objectIds
     */
    private function updateQuery(?array $objectIds = null): QueryBuilder
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable($this->table);
        $queryBuilder
            ->update($this->table)
            ->where(
                $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($this->storagePageId, ParameterType::INTEGER)),
                $queryBuilder->expr()->gt('object_id', $queryBuilder->createNamedParameter(0, ParameterType::INTEGER)),
                $queryBuilder->expr()->eq('deleted', $queryBuilder->createNamedParameter(0, ParameterType::INTEGER))
            );
        if ($objectIds !== null) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->in('object_id', $queryBuilder->createNamedParameter($objectIds, ArrayParameterType::INTEGER))
            );
        }

        return $queryBuilder;
    }

    /**
     * Restores the records the import deleted once the middleware has seen them again since.
     * Returns the object ids of the others: save() can't see hidden or deleted records and
     * would insert them again, so they must not be dispatched.
     *
     * @param array<int, int|null> $lastSeen
     * @return array<int, true>
     */
    private function restoreDelivered(array $lastSeen): array
    {
        if ($lastSeen === []) {
            return [];
        }

        $queryBuilder = $this->connectionPool->getQueryBuilderForTable($this->table);
        $queryBuilder->getRestrictions()->removeAll();
        $rows = $queryBuilder
            ->select('uid', 'object_id', 'hidden', 'deleted', 'soft_deleted_at')
            ->from($this->table)
            ->where(
                $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($this->storagePageId, ParameterType::INTEGER)),
                $queryBuilder->expr()->in('object_id', $queryBuilder->createNamedParameter(array_keys($lastSeen), ArrayParameterType::INTEGER)),
                $queryBuilder->expr()->gt('soft_deleted_at', $queryBuilder->createNamedParameter(0, ParameterType::INTEGER))
            )
            ->executeQuery()
            ->fetchAllAssociative();

        $stillDeleted = [];
        $connection = $this->connectionPool->getConnectionForTable($this->table);
        foreach ($rows as $row) {
            $objectId = (int)$row['object_id'];
            // A record without lastSeenAt counts as seen again
            if (($lastSeen[$objectId] ?? PHP_INT_MAX) <= (int)$row['soft_deleted_at']) {
                $stillDeleted[$objectId] = true;
                continue;
            }
            // A hard deleted record that comes back is created anew by save()
            if ((int)$row['deleted'] === 1) {
                continue;
            }
            $changes = ['soft_deleted_at' => 0];
            if ((int)$row['hidden'] === 1) {
                $changes += ['hidden' => 0, 'tstamp' => time()];
                $this->restored++;
            }
            $connection->update($this->table, $changes, ['uid' => (int)$row['uid']]);
        }

        return $stillDeleted;
    }

    /**
     * One UPDATE per distinct timestamp instead of one per record.
     *
     * @param array<int, int|null> $timestamps per object id
     * @return array<int, int[]> object ids per timestamp
     */
    private function groupByTimestamp(array $timestamps, int $fallback): array
    {
        $groups = [];
        foreach ($timestamps as $objectId => $timestamp) {
            $groups[$timestamp ?? $fallback][] = $objectId;
        }

        return $groups;
    }
}
