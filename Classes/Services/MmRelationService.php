<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Services;

use Doctrine\DBAL\ArrayParameterType;
use Doctrine\DBAL\ParameterType;
use TYPO3\CMS\Core\Database\ConnectionPool;

/**
 * Handles MM (many-to-many) relation maintenance via raw DBAL,
 * completely bypassing Extbase's ORM layer.
 *
 * This avoids the N+1 query problem, ObjectStorage lazy-load explosions,
 * and the Extbase identity-map memory leak that occur when using
 * Extbase repositories for bulk import attachment operations.
 *
 * Terminology used throughout this class
 * ---------------------------------------
 * "Owner"   = the DB table whose TCA field defines the MM relation
 *             (uid_local side; e.g. tx_hiotypo3connector_domain_model_person
 *              for the person.publications select field).
 * "Related" = the DB table being referenced
 *             (uid_foreign side; e.g. tx_hiotypo3connector_domain_model_publication).
 *
 * All tables are expected to have:
 *  - an `object_id` INT column (HISinOne business key)
 *  - a `deleted`   TINYINT column (TYPO3 soft-delete)
 *
 * MM tables follow the TYPO3 standard structure:
 *  - `uid_local`   INT  (owner uid)
 *  - `uid_foreign` INT  (related uid)
 *  - `sorting`     INT
 *
 * Re-import optimisation (the dominant production use-case)
 * ---------------------------------------------------------
 * Both public methods use a two-step COUNT fast-path before loading any
 * MM rows into PHP memory:
 *
 *   1. COUNT(*) current MM rows  →  if count already matches expected,
 *   2. COUNT(*) matching UIDs   →  verify the set is identical.
 *
 * When nothing changed (the common case) this costs exactly 2 × COUNT
 * queries and zero PHP arrays for current MM state.  Only when a real
 * change is detected does the slow-path load the current rows and diff.
 */
class MmRelationService
{
    public function __construct(private readonly ConnectionPool $connectionPool)
    {
    }

    // -------------------------------------------------------------------------
    // Public API
    // -------------------------------------------------------------------------

    /**
     * Syncs the MM entries for a single **owner** record to match the given
     * list of related records exactly.
     *
     * Use-case: "Person A (owner of the `publications` field) now has
     *            publications P1, P2, P3."
     *
     * @param string   $ownerTable          DB table of the owner record (uid_local)
     * @param int      $ownerObjectId       object_id of the owner record
     * @param string   $relatedTable        DB table of the related records (uid_foreign)
     * @param int[]    $relatedObjectIds    object_ids of the related records
     * @param string   $mmTable             MM join table
     * @param string   $ownerCounterColumn  column on $ownerTable storing the relation count
     */
    public function syncRelationsOfOwner(
        string $ownerTable,
        int    $ownerObjectId,
        string $relatedTable,
        array  $relatedObjectIds,
        string $mmTable,
        string $ownerCounterColumn
    ): void {
        $ownerUid = $this->getUidByObjectId($ownerTable, $ownerObjectId);
        if ($ownerUid === null) {
            return;
        }

        $newRelatedUids = empty($relatedObjectIds)
            ? []
            : $this->getUidsByObjectIds($relatedTable, array_values(array_filter($relatedObjectIds)));
        $newCount = count($newRelatedUids);

        $mmConn    = $this->connectionPool->getConnectionForTable($mmTable);
        $ownerConn = $this->connectionPool->getConnectionForTable($ownerTable);

        $currentCount = (int)$mmConn->count('*', $mmTable, ['uid_local' => $ownerUid]);

        // Fast-path A: both sides empty — nothing to do.
        if ($currentCount === 0 && $newCount === 0) {
            return;
        }

        // Fast-path B: counts match — verify the exact set with a second COUNT
        // query rather than loading all MM rows into PHP memory.
        // This is the common path on re-import of unchanged data.
        if ($currentCount === $newCount && $newCount > 0) {
            $matchingCount = $this->countMatchingMmEntries(
                $mmTable, 'uid_local', $ownerUid, 'uid_foreign', $newRelatedUids
            );
            if ($matchingCount === $newCount) {
                return; // Set is identical — nothing to write
            }
        }

        // Slow-path: counts or contents differ — load current rows and diff.
        $currentUids = array_map('intval', array_column(
            $mmConn->select(['uid_foreign'], $mmTable, ['uid_local' => $ownerUid])->fetchAllAssociative(),
            'uid_foreign'
        ));

        $toAdd    = array_diff($newRelatedUids, $currentUids);
        $toRemove = array_diff($currentUids, $newRelatedUids);

        foreach ($toRemove as $uid) {
            $mmConn->delete($mmTable, ['uid_local' => $ownerUid, 'uid_foreign' => $uid]);
        }

        $sorting = $currentCount - count($toRemove);
        foreach ($toAdd as $uid) {
            $mmConn->insert($mmTable, [
                'uid_local'   => $ownerUid,
                'uid_foreign' => $uid,
                'sorting'     => ++$sorting,
            ]);
        }

        $ownerConn->update($ownerTable, [$ownerCounterColumn => $newCount], ['uid' => $ownerUid]);
    }

    /**
     * Syncs the MM entries for a single **related** record to match the given
     * list of owner records exactly.
     *
     * Counter columns are only refreshed for owners whose relations changed.
     *
     * Use-case: "Publication P (related) is now authored by persons A, B, C
     *            (owners of the `publications` field)."
     *
     * @param string   $ownerTable          DB table of the owner records (uid_local)
     * @param int[]    $ownerObjectIds      object_ids of the owner records
     * @param string   $relatedTable        DB table of the related record (uid_foreign)
     * @param int      $relatedObjectId     object_id of the related record
     * @param string   $mmTable             MM join table
     * @param string   $ownerCounterColumn  column on $ownerTable storing the relation count
     */
    public function syncOwnersOfRelated(
        string $ownerTable,
        array  $ownerObjectIds,
        string $relatedTable,
        int    $relatedObjectId,
        string $mmTable,
        string $ownerCounterColumn
    ): void {
        $relatedUid = $this->getUidByObjectId($relatedTable, $relatedObjectId);
        if ($relatedUid === null) {
            return;
        }

        $newOwnerUids = empty($ownerObjectIds)
            ? []
            : $this->getUidsByObjectIds($ownerTable, array_values(array_filter($ownerObjectIds)));
        $newCount = count($newOwnerUids);

        $mmConn    = $this->connectionPool->getConnectionForTable($mmTable);
        $ownerConn = $this->connectionPool->getConnectionForTable($ownerTable);

        $currentCount = (int)$mmConn->count('*', $mmTable, ['uid_foreign' => $relatedUid]);

        // Fast-path A
        if ($currentCount === 0 && $newCount === 0) {
            return;
        }

        // Fast-path B
        if ($currentCount === $newCount && $newCount > 0) {
            $matchingCount = $this->countMatchingMmEntries(
                $mmTable, 'uid_foreign', $relatedUid, 'uid_local', $newOwnerUids
            );
            if ($matchingCount === $newCount) {
                return;
            }
        }

        // Slow-path
        $currentOwnerUids = array_map('intval', array_column(
            $mmConn->select(['uid_local'], $mmTable, ['uid_foreign' => $relatedUid])->fetchAllAssociative(),
            'uid_local'
        ));

        $toAdd    = array_diff($newOwnerUids, $currentOwnerUids);
        $toRemove = array_diff($currentOwnerUids, $newOwnerUids);

        foreach ($toRemove as $uid) {
            $mmConn->delete($mmTable, ['uid_local' => $uid, 'uid_foreign' => $relatedUid]);
        }

        $sorting = $currentCount - count($toRemove);
        foreach ($toAdd as $ownerUid) {
            $mmConn->insert($mmTable, [
                'uid_local'   => $ownerUid,
                'uid_foreign' => $relatedUid,
                'sorting'     => ++$sorting,
            ]);
        }

        // Only refresh counters for owners that actually changed
        $changedOwners = array_merge(array_values($toAdd), array_values($toRemove));
        foreach ($changedOwners as $ownerUid) {
            $count = (int)$mmConn->count('*', $mmTable, ['uid_local' => $ownerUid]);
            $ownerConn->update($ownerTable, [$ownerCounterColumn => $count], ['uid' => $ownerUid]);
        }
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    /**
     * Returns the TYPO3 uid for a record identified by its HISinOne object_id.
     */
    private function getUidByObjectId(string $table, int $objectId): ?int
    {
        $row = $this->connectionPool
            ->getConnectionForTable($table)
            ->select(['uid'], $table, ['object_id' => $objectId, 'deleted' => 0])
            ->fetchAssociative();

        return $row !== false ? (int)$row['uid'] : null;
    }

    /**
     * Batch-fetches TYPO3 uids for records identified by HISinOne object_ids.
     * Uses a single IN query instead of N individual lookups.
     *
     * @param  string $table
     * @param  int[]  $objectIds
     * @return int[]
     */
    private function getUidsByObjectIds(string $table, array $objectIds): array
    {
        if (empty($objectIds)) {
            return [];
        }

        $qb = $this->connectionPool->getQueryBuilderForTable($table);
        $rows = $qb
            ->select('uid')
            ->from($table)
            ->where(
                $qb->expr()->in(
                    'object_id',
                    $qb->createNamedParameter($objectIds, ArrayParameterType::INTEGER)
                ),
                $qb->expr()->eq('deleted', $qb->createNamedParameter(0, ParameterType::INTEGER))
            )
            ->executeQuery()
            ->fetchAllAssociative();

        return array_map('intval', array_column($rows, 'uid'));
    }

    /**
     * Counts how many MM rows have $fixedCol = $fixedUid AND $setCol IN ($setUids).
     *
     * Used by both fast-path B checks to confirm set equality without loading
     * rows into PHP memory.
     *
     * @param  int[]  $setUids
     */
    private function countMatchingMmEntries(
        string $mmTable,
        string $fixedCol,
        int    $fixedUid,
        string $setCol,
        array  $setUids
    ): int {
        if (empty($setUids)) {
            return 0;
        }

        $qb = $this->connectionPool->getQueryBuilderForTable($mmTable);
        return (int)$qb
            ->count($setCol)
            ->from($mmTable)
            ->where(
                $qb->expr()->eq($fixedCol, $qb->createNamedParameter($fixedUid, ParameterType::INTEGER)),
                $qb->expr()->in($setCol, $qb->createNamedParameter($setUids, ArrayParameterType::INTEGER))
            )
            ->executeQuery()
            ->fetchOne();
    }
}
