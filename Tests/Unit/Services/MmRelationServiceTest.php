<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\Services;

use Doctrine\DBAL\Result;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Services\MmRelationService;

/**
 * Unit tests for MmRelationService.
 *
 * All DB access is mocked via ConnectionPool / Connection / QueryBuilder doubles.
 * Tests cover:
 *  - Early returns when owner / related record is not found in the DB.
 *  - Fast-path A: nothing to do because both sides are empty.
 *  - Fast-path B: nothing to do because the current MM set is already identical.
 *  - Slow-path inserts and deletes with counter-column updates.
 */
final class MmRelationServiceTest extends UnitTestCase
{
    // Fixtures – a person ↔ publication many-to-many relation
    private const OWNER_TABLE   = 'tx_hiotypo3connector_domain_model_person';
    private const RELATED_TABLE = 'tx_hiotypo3connector_domain_model_publication';
    private const MM_TABLE      = 'tx_hiotypo3connector_person_publication_mm';
    private const COUNTER_COL   = 'publications';

    // Concrete IDs used in assertions
    private const OWNER_OBJECT_ID   = 42;
    private const RELATED_OBJECT_ID = 99;
    private const OWNER_UID         = 1;
    private const RELATED_UID       = 10;

    // =========================================================================
    // syncRelationsOfOwner
    // =========================================================================

    #[Test]
    public function syncRelationsOfOwner_ownerNotFound_returnsEarlyWithoutAnyDbWrite(): void
    {
        $ownerConn = $this->makeConnection($this->makeNotFoundResult());
        $ownerConn->expects(self::never())->method('update');

        $mmConn = $this->createMock(Connection::class);
        $mmConn->expects(self::never())->method('count');
        $mmConn->expects(self::never())->method('insert');
        $mmConn->expects(self::never())->method('delete');

        $pool = $this->makePool(ownerConn: $ownerConn, mmConn: $mmConn);

        (new MmRelationService($pool))->syncRelationsOfOwner(
            self::OWNER_TABLE, self::OWNER_OBJECT_ID,
            self::RELATED_TABLE, [self::RELATED_OBJECT_ID],
            self::MM_TABLE, self::COUNTER_COL,
        );
    }

    #[Test]
    public function syncRelationsOfOwner_bothSidesEmpty_fastPathSkipsAllDbWrites(): void
    {
        $ownerConn = $this->makeConnection($this->makeFoundResult(self::OWNER_UID));
        $ownerConn->expects(self::never())->method('update');

        $mmConn = $this->createMock(Connection::class);
        $mmConn->method('count')->willReturn(0); // MM table already empty
        $mmConn->expects(self::never())->method('insert');
        $mmConn->expects(self::never())->method('delete');

        $pool = $this->makePool(ownerConn: $ownerConn, mmConn: $mmConn);

        (new MmRelationService($pool))->syncRelationsOfOwner(
            self::OWNER_TABLE, self::OWNER_OBJECT_ID,
            self::RELATED_TABLE, [], // no related IDs supplied
            self::MM_TABLE, self::COUNTER_COL,
        );
    }

    #[Test]
    public function syncRelationsOfOwner_identicalRelatedSet_fastPathSkipsAllDbWrites(): void
    {
        $ownerConn = $this->makeConnection($this->makeFoundResult(self::OWNER_UID));
        $ownerConn->expects(self::never())->method('update');

        $mmConn = $this->createMock(Connection::class);
        $mmConn->method('count')->willReturn(1); // current count = new count = 1
        $mmConn->expects(self::never())->method('insert');
        $mmConn->expects(self::never())->method('delete');

        // related UID batch-lookup: object_id 99 → DB uid 100
        $relatedQb = $this->makeQueryBuilder(fetchAllRows: [['uid' => 100]]);
        // fast-path B COUNT check: 1 matching row means set is identical
        $mmQb      = $this->makeQueryBuilder(fetchOneValue: 1);

        $pool = $this->makePool(
            ownerConn:  $ownerConn,
            mmConn:     $mmConn,
            relatedQb:  $relatedQb,
            mmQb:       $mmQb,
        );

        (new MmRelationService($pool))->syncRelationsOfOwner(
            self::OWNER_TABLE, self::OWNER_OBJECT_ID,
            self::RELATED_TABLE, [self::RELATED_OBJECT_ID],
            self::MM_TABLE, self::COUNTER_COL,
        );
    }

    #[Test]
    public function syncRelationsOfOwner_newRelatedRecord_insertsRowAndUpdatesCounter(): void
    {
        $ownerConn = $this->makeConnection($this->makeFoundResult(self::OWNER_UID));
        $ownerConn->expects(self::once())
            ->method('update')
            ->with(self::OWNER_TABLE, [self::COUNTER_COL => 1], ['uid' => self::OWNER_UID]);

        // MM currently empty → count=0, no existing rows
        $mmConn = $this->createMock(Connection::class);
        $mmConn->method('count')->willReturn(0); // current=0, new=1 → slow-path
        $mmConn->method('select')->willReturn($this->makeSelectAllResult([]));
        $mmConn->expects(self::once())
            ->method('insert')
            ->with(self::MM_TABLE, ['uid_local' => self::OWNER_UID, 'uid_foreign' => 100, 'sorting' => 1]);
        $mmConn->expects(self::never())->method('delete');

        // related UID lookup: object_id 99 → DB uid 100
        $relatedQb = $this->makeQueryBuilder(fetchAllRows: [['uid' => 100]]);
        $pool      = $this->makePool(ownerConn: $ownerConn, mmConn: $mmConn, relatedQb: $relatedQb);

        (new MmRelationService($pool))->syncRelationsOfOwner(
            self::OWNER_TABLE, self::OWNER_OBJECT_ID,
            self::RELATED_TABLE, [self::RELATED_OBJECT_ID],
            self::MM_TABLE, self::COUNTER_COL,
        );
    }

    #[Test]
    public function syncRelationsOfOwner_removedRelatedRecord_deletesRowAndUpdatesCounter(): void
    {
        $ownerConn = $this->makeConnection($this->makeFoundResult(self::OWNER_UID));
        $ownerConn->expects(self::once())
            ->method('update')
            ->with(self::OWNER_TABLE, [self::COUNTER_COL => 0], ['uid' => self::OWNER_UID]);

        // MM currently has one row for uid_foreign=100
        $mmConn = $this->createMock(Connection::class);
        $mmConn->method('count')->willReturn(1); // current=1, new=0 → slow-path
        $mmConn->method('select')->willReturn($this->makeSelectAllResult([['uid_foreign' => 100]]));
        $mmConn->expects(self::once())
            ->method('delete')
            ->with(self::MM_TABLE, ['uid_local' => self::OWNER_UID, 'uid_foreign' => 100]);
        $mmConn->expects(self::never())->method('insert');

        $pool = $this->makePool(ownerConn: $ownerConn, mmConn: $mmConn);

        (new MmRelationService($pool))->syncRelationsOfOwner(
            self::OWNER_TABLE, self::OWNER_OBJECT_ID,
            self::RELATED_TABLE, [], // all relations cleared
            self::MM_TABLE, self::COUNTER_COL,
        );
    }

    // =========================================================================
    // syncOwnersOfRelated
    // =========================================================================

    #[Test]
    public function syncOwnersOfRelated_relatedNotFound_returnsEarlyWithoutAnyDbWrite(): void
    {
        $relatedConn = $this->makeConnection($this->makeNotFoundResult());

        $ownerConn = $this->createMock(Connection::class);
        $ownerConn->expects(self::never())->method('update');

        $mmConn = $this->createMock(Connection::class);
        $mmConn->expects(self::never())->method('count');
        $mmConn->expects(self::never())->method('insert');
        $mmConn->expects(self::never())->method('delete');

        $pool = $this->makePool(relatedConn: $relatedConn, ownerConn: $ownerConn, mmConn: $mmConn);

        (new MmRelationService($pool))->syncOwnersOfRelated(
            self::OWNER_TABLE, [self::OWNER_OBJECT_ID],
            self::RELATED_TABLE, self::RELATED_OBJECT_ID,
            self::MM_TABLE, self::COUNTER_COL,
        );
    }

    #[Test]
    public function syncOwnersOfRelated_bothSidesEmpty_fastPathSkipsAllDbWrites(): void
    {
        $relatedConn = $this->makeConnection($this->makeFoundResult(self::RELATED_UID));

        $ownerConn = $this->createMock(Connection::class);
        $ownerConn->expects(self::never())->method('update');

        $mmConn = $this->createMock(Connection::class);
        $mmConn->method('count')->willReturn(0); // MM table already empty
        $mmConn->expects(self::never())->method('insert');
        $mmConn->expects(self::never())->method('delete');

        $pool = $this->makePool(relatedConn: $relatedConn, ownerConn: $ownerConn, mmConn: $mmConn);

        (new MmRelationService($pool))->syncOwnersOfRelated(
            self::OWNER_TABLE, [], // no owner IDs supplied
            self::RELATED_TABLE, self::RELATED_OBJECT_ID,
            self::MM_TABLE, self::COUNTER_COL,
        );
    }

    #[Test]
    public function syncOwnersOfRelated_newOwnerRecord_insertsRowAndUpdatesOwnerCounter(): void
    {
        $relatedConn = $this->makeConnection($this->makeFoundResult(self::RELATED_UID));

        // Counter update must carry the post-insert count fetched from the MM table
        $ownerConn = $this->createMock(Connection::class);
        $ownerConn->expects(self::once())
            ->method('update')
            ->with(self::OWNER_TABLE, [self::COUNTER_COL => 3], ['uid' => self::OWNER_UID]);

        // MM: currently 0 owners; after insert the counter lookup returns 3
        $mmConn = $this->createMock(Connection::class);
        $mmConn->method('count')->willReturnOnConsecutiveCalls(0, 3); // initial=0, post-insert=3
        $mmConn->method('select')->willReturn($this->makeSelectAllResult([]));
        $mmConn->expects(self::once())
            ->method('insert')
            ->with(self::MM_TABLE, [
                'uid_local'   => self::OWNER_UID,
                'uid_foreign' => self::RELATED_UID,
                'sorting'     => 1,
            ]);
        $mmConn->expects(self::never())->method('delete');

        // owner UID batch-lookup: object_id 42 → DB uid 1
        $ownerQb = $this->makeQueryBuilder(fetchAllRows: [['uid' => self::OWNER_UID]]);

        $pool = $this->makePool(
            relatedConn: $relatedConn,
            ownerConn:   $ownerConn,
            mmConn:      $mmConn,
            ownerQb:     $ownerQb,
        );

        (new MmRelationService($pool))->syncOwnersOfRelated(
            self::OWNER_TABLE, [self::OWNER_OBJECT_ID],
            self::RELATED_TABLE, self::RELATED_OBJECT_ID,
            self::MM_TABLE, self::COUNTER_COL,
        );
    }

    #[Test]
    public function syncOwnersOfRelated_removedOwnerRecord_deletesRowAndUpdatesOwnerCounter(): void
    {
        $relatedConn = $this->makeConnection($this->makeFoundResult(self::RELATED_UID));

        // After deletion the counter for owner uid=1 must be updated to 0
        $ownerConn = $this->createMock(Connection::class);
        $ownerConn->expects(self::once())
            ->method('update')
            ->with(self::OWNER_TABLE, [self::COUNTER_COL => 0], ['uid' => self::OWNER_UID]);

        // MM: currently 1 owner (uid_local=1); no new owners → delete row
        $mmConn = $this->createMock(Connection::class);
        $mmConn->method('count')->willReturnOnConsecutiveCalls(1, 0); // initial=1, post-delete=0
        $mmConn->method('select')->willReturn(
            $this->makeSelectAllResult([['uid_local' => self::OWNER_UID]])
        );
        $mmConn->expects(self::once())
            ->method('delete')
            ->with(self::MM_TABLE, ['uid_local' => self::OWNER_UID, 'uid_foreign' => self::RELATED_UID]);
        $mmConn->expects(self::never())->method('insert');

        $pool = $this->makePool(relatedConn: $relatedConn, ownerConn: $ownerConn, mmConn: $mmConn);

        (new MmRelationService($pool))->syncOwnersOfRelated(
            self::OWNER_TABLE, [], // all owners cleared
            self::RELATED_TABLE, self::RELATED_OBJECT_ID,
            self::MM_TABLE, self::COUNTER_COL,
        );
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    /** Result returning a single row with 'uid' => $uid. */
    private function makeFoundResult(int $uid): Result
    {
        $result = $this->createMock(Result::class);
        $result->method('fetchAssociative')->willReturn(['uid' => $uid]);
        return $result;
    }

    /** Result returning false – simulates a "record not found" lookup. */
    private function makeNotFoundResult(): Result
    {
        $result = $this->createMock(Result::class);
        $result->method('fetchAssociative')->willReturn(false);
        return $result;
    }

    /** Result whose fetchAllAssociative() returns the given rows. */
    private function makeSelectAllResult(array $rows): Result
    {
        $result = $this->createMock(Result::class);
        $result->method('fetchAllAssociative')->willReturn($rows);
        return $result;
    }

    /** Connection mock that returns $selectResult from select(). */
    private function makeConnection(Result $selectResult): Connection
    {
        $conn = $this->createMock(Connection::class);
        $conn->method('select')->willReturn($selectResult);
        return $conn;
    }

    /**
     * QueryBuilder mock whose full fluent chain terminates in a Result that
     * delivers $fetchAllRows from fetchAllAssociative() and $fetchOneValue
     * from fetchOne().
     */
    private function makeQueryBuilder(array $fetchAllRows = [], mixed $fetchOneValue = null): QueryBuilder
    {
        $result = $this->createMock(Result::class);
        $result->method('fetchAllAssociative')->willReturn($fetchAllRows);
        if ($fetchOneValue !== null) {
            $result->method('fetchOne')->willReturn($fetchOneValue);
        }

        $expr = $this->createMock(ExpressionBuilder::class);
        $expr->method('in')->willReturn('1=1');
        $expr->method('eq')->willReturn('1=1');

        $qb = $this->createMock(QueryBuilder::class);
        $qb->method('select')->willReturnSelf();
        $qb->method('count')->willReturnSelf();
        $qb->method('from')->willReturnSelf();
        $qb->method('where')->willReturnSelf();
        $qb->method('expr')->willReturn($expr);
        $qb->method('createNamedParameter')->willReturn(':param');
        $qb->method('executeQuery')->willReturn($result);

        return $qb;
    }

    /**
     * ConnectionPool mock that routes getConnectionForTable / getQueryBuilderForTable
     * calls to the supplied per-table doubles.
     *
     * Passing null for a slot is intentional: a bare createMock() is returned
     * so PHPUnit can still track unexpected calls as test failures.
     */
    private function makePool(
        ?Connection   $ownerConn   = null,
        ?Connection   $relatedConn = null,
        ?Connection   $mmConn      = null,
        ?QueryBuilder $ownerQb     = null,
        ?QueryBuilder $relatedQb   = null,
        ?QueryBuilder $mmQb        = null,
    ): ConnectionPool {
        $pool = $this->createMock(ConnectionPool::class);

        $pool->method('getConnectionForTable')
            ->willReturnCallback(
                fn(string $t) => match ($t) {
                    self::OWNER_TABLE   => $ownerConn   ?? $this->createMock(Connection::class),
                    self::RELATED_TABLE => $relatedConn ?? $this->createMock(Connection::class),
                    self::MM_TABLE      => $mmConn      ?? $this->createMock(Connection::class),
                    default             => throw new \RuntimeException("Unexpected table in getConnectionForTable: $t"),
                }
            );

        $pool->method('getQueryBuilderForTable')
            ->willReturnCallback(
                fn(string $t) => match ($t) {
                    self::OWNER_TABLE   => $ownerQb   ?? $this->createMock(QueryBuilder::class),
                    self::RELATED_TABLE => $relatedQb ?? $this->createMock(QueryBuilder::class),
                    self::MM_TABLE      => $mmQb      ?? $this->createMock(QueryBuilder::class),
                    default             => throw new \RuntimeException("Unexpected table in getQueryBuilderForTable: $t"),
                }
            );

        return $pool;
    }
}

