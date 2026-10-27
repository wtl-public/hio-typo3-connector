<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\Services\RecordLifecycle;

use Doctrine\DBAL\Result;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Console\Output\BufferedOutput;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Database\Query\Restriction\QueryRestrictionContainerInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Domain\Dto\ProjectDto;
use Wtl\HioTypo3Connector\Publisher\ApiResponse;
use Wtl\HioTypo3Connector\Services\HioApiService;
use Wtl\HioTypo3Connector\Services\RecordLifecycle\RecordLifecycleRun;

/**
 * Unit tests for RecordLifecycleRun.
 *
 * All DB access is mocked via ConnectionPool / Connection / QueryBuilder doubles,
 * the current page of the middleware response is a real ApiResponse.
 * Tests cover:
 *  - beforeDispatch(): which soft deleted records are restored and dispatched, and which stay deleted.
 *  - finish(): no UPDATE without any lastSeenAt/deletedAt in the run.
 *  - finish(): the summary and its counts.
 */
#[CoversClass(RecordLifecycleRun::class)]
final class RecordLifecycleRunTest extends UnitTestCase
{
    private const TABLE = 'tx_hiotypo3connector_domain_model_project';
    private const STORAGE_PAGE_ID = 42;
    private const LABEL = 'Projects';

    // =========================================================================
    // beforeDispatch
    // =========================================================================

    #[Test]
    public function beforeDispatch_restoresRecordsSeenSinceSoftDeleteAndDropsTheOthers(): void
    {
        $lastSeenAt = '2026-01-10T08:00:00+00:00';
        $response = $this->makeResponse([
            ['id' => 1, 'lastSeenAt' => $lastSeenAt],
            ['id' => 2, 'lastSeenAt' => $lastSeenAt],
            ['id' => 3, 'lastSeenAt' => $lastSeenAt],
            ['id' => 4, 'lastSeenAt' => $lastSeenAt],
        ]);
        // Stored soft deleted records: 1 deleted at lastSeenAt, 2 after it, 3 before it; 4 is not soft deleted
        $queryBuilder = $this->makeQueryBuilder(selectRows: [
            ['uid' => 11, 'object_id' => 1, 'hidden' => 1, 'deleted' => 0, 'soft_deleted_at' => strtotime($lastSeenAt)],
            ['uid' => 12, 'object_id' => 2, 'hidden' => 1, 'deleted' => 0, 'soft_deleted_at' => strtotime('2026-01-11T00:00:00+00:00')],
            ['uid' => 13, 'object_id' => 3, 'hidden' => 1, 'deleted' => 0, 'soft_deleted_at' => strtotime('2026-01-05T00:00:00+00:00')],
        ]);

        $connection = $this->createMock(Connection::class);
        $connection->expects(self::once())
            ->method('update')
            ->with(self::TABLE, self::callback($this->isRestore(...)), ['uid' => 13]);

        $run = $this->makeRun($response, $queryBuilder, $connection);
        $dispatched = $run->beforeDispatch($this->makeRecords(1, 2, 3, 4));

        self::assertSame([3, 4], $this->objectIds($dispatched));
    }

    #[Test]
    public function beforeDispatch_recordWithoutLastSeenAtCountsAsSeen(): void
    {
        $response = $this->makeResponse([['id' => 5]]);
        $queryBuilder = $this->makeQueryBuilder(selectRows: [
            ['uid' => 15, 'object_id' => 5, 'hidden' => 1, 'deleted' => 0, 'soft_deleted_at' => strtotime('2026-01-05T00:00:00+00:00')],
        ]);

        $connection = $this->createMock(Connection::class);
        $connection->expects(self::once())
            ->method('update')
            ->with(self::TABLE, self::callback($this->isRestore(...)), ['uid' => 15]);

        $run = $this->makeRun($response, $queryBuilder, $connection);
        $dispatched = $run->beforeDispatch($this->makeRecords(5));

        self::assertSame([5], $this->objectIds($dispatched));
    }

    // =========================================================================
    // finish
    // =========================================================================

    #[Test]
    public function finish_runWithoutOptionsAndTimestamps_printsOnlyTheImportedLine(): void
    {
        $response = $this->makeResponse([['id' => 1], ['id' => 2]]);
        $queryBuilder = $this->makeQueryBuilder();
        $connection = $this->createMock(Connection::class);
        $connection->expects(self::never())->method('update');

        $output = $this->runPage($this->makeRun($response, $queryBuilder, $connection), [1, 2]);

        self::assertSame("2 Projects imported successfully\n", $output);
    }

    #[Test]
    public function finish_runWithoutTimestamps_issuesNoUpdateEvenWithDeleteDaysSet(): void
    {
        $response = $this->makeResponse([['id' => 1], ['id' => 2]]);
        $queryBuilder = $this->makeQueryBuilder();
        $connection = $this->createMock(Connection::class);
        $connection->expects(self::never())->method('update');

        $run = $this->makeRun($response, $queryBuilder, $connection, withTrashed: true, softDays: 7, hardDays: 30);
        $output = $this->runPage($run, [1, 2]);

        self::assertSame(
            "2 Projects imported successfully\n"
            . "0 Projects soft deleted successfully\n"
            . "0 Projects hard deleted successfully\n",
            $output
        );
    }

    #[Test]
    public function finish_summaryCountsImportedRestoredSoftAndHardDeletedRecords(): void
    {
        $lastSeenAt = '2026-01-10T08:00:00+00:00';
        // total 10 of which 1 trashed; of the 3 live records on this page, 1 stays deleted and 1 is restored
        $response = $this->makeResponse(
            [
                ['id' => 1, 'lastSeenAt' => $lastSeenAt],
                ['id' => 2, 'lastSeenAt' => $lastSeenAt],
                ['id' => 3, 'lastSeenAt' => $lastSeenAt],
                ['id' => 9, 'deletedAt' => '2026-01-09T12:00:00+00:00'],
            ],
            total: 10
        );
        // UPDATEs in order: soft delete trashed (1), Last Seen of the page and missing Last Seen (both ignored),
        // soft delete stale (2), hard delete (3)
        $queryBuilder = $this->makeQueryBuilder(
            selectRows: [
                ['uid' => 11, 'object_id' => 1, 'hidden' => 1, 'deleted' => 0, 'soft_deleted_at' => strtotime($lastSeenAt)],
                ['uid' => 12, 'object_id' => 2, 'hidden' => 1, 'deleted' => 0, 'soft_deleted_at' => strtotime('2026-01-05T00:00:00+00:00')],
            ],
            statementResults: [1, 3, 5, 2, 3]
        );

        $run = $this->makeRun($response, $queryBuilder, $this->createStub(Connection::class), withTrashed: true, softDays: 7, hardDays: 30);
        $output = $this->runPage($run, [1, 2, 3]);

        self::assertSame(
            "8 Projects imported successfully (1 restored)\n"
            . "3 Projects soft deleted successfully\n"
            . "3 Projects hard deleted successfully\n",
            $output
        );
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    /**
     * Runs one page through the run as the import commands do and returns the summary.
     *
     * @param int[] $objectIds of the records on the page
     */
    private function runPage(RecordLifecycleRun $run, array $objectIds): string
    {
        $run->beforeDispatch($this->makeRecords(...$objectIds));
        $run->afterDispatch();
        $output = new BufferedOutput();
        $run->finish($output, self::LABEL);

        return $output->fetch();
    }

    /** Connection::update() changes of a restore: shown again, soft delete mark cleared. */
    private function isRestore(array $changes): bool
    {
        ksort($changes);

        return array_keys($changes) === ['hidden', 'soft_deleted_at', 'tstamp']
            && $changes['soft_deleted_at'] === 0
            && $changes['hidden'] === 0
            && is_int($changes['tstamp']) && $changes['tstamp'] > 0;
    }

    /**
     * Middleware page of one page; meta total defaults to the number of rows.
     */
    private function makeResponse(array $rows, ?int $total = null): ApiResponse
    {
        $total ??= count($rows);

        return new ApiResponse(
            $rows,
            [
                'current_page' => 1,
                'from' => 1,
                'last_page' => 1,
                'links' => [],
                'path' => 'https://middleware.example/api/projects',
                'per_page' => 25,
                'to' => $total,
                'total' => $total,
            ],
            []
        );
    }

    /**
     * QueryBuilder double whose fluent chain returns itself; executeQuery() delivers $selectRows.
     * Without $statementResults it expects no UPDATE at all, otherwise executeStatement()
     * returns these affected-row counts in order.
     *
     * @param list<int>|null $statementResults
     */
    private function makeQueryBuilder(array $selectRows = [], ?array $statementResults = null): QueryBuilder
    {
        $result = $this->createStub(Result::class);
        $result->method('fetchAllAssociative')->willReturn($selectRows);

        $expr = $this->createStub(ExpressionBuilder::class);
        $expr->method('eq')->willReturn('1=1');
        $expr->method('gt')->willReturn('1=1');
        $expr->method('lt')->willReturn('1=1');
        $expr->method('in')->willReturn('1=1');

        if ($statementResults === null) {
            $queryBuilder = $this->createMock(QueryBuilder::class);
            $queryBuilder->expects(self::never())->method('executeStatement');
        } else {
            $queryBuilder = $this->createStub(QueryBuilder::class);
            $queryBuilder->method('executeStatement')->willReturnOnConsecutiveCalls(...$statementResults);
        }
        $queryBuilder->method('getRestrictions')->willReturn($this->createStub(QueryRestrictionContainerInterface::class));
        foreach (['select', 'from', 'update', 'set', 'where', 'andWhere'] as $method) {
            $queryBuilder->method($method)->willReturnSelf();
        }
        $queryBuilder->method('expr')->willReturn($expr);
        $queryBuilder->method('createNamedParameter')->willReturn(':param');
        $queryBuilder->method('quoteIdentifier')->willReturnArgument(0);
        $queryBuilder->method('executeQuery')->willReturn($result);

        return $queryBuilder;
    }

    private function makeRun(
        ApiResponse $response,
        QueryBuilder $queryBuilder,
        Connection $connection,
        bool $withTrashed = false,
        ?int $softDays = null,
        ?int $hardDays = null
    ): RecordLifecycleRun {
        $apiService = $this->createStub(HioApiService::class);
        $apiService->method('getResponse')->willReturn($response);
        $apiService->method('getMeta')->willReturn($response->getMeta());

        $pool = $this->createStub(ConnectionPool::class);
        $pool->method('getQueryBuilderForTable')->willReturn($queryBuilder);
        $pool->method('getConnectionForTable')->willReturn($connection);

        return new RecordLifecycleRun(
            $pool,
            $apiService,
            self::TABLE,
            self::STORAGE_PAGE_ID,
            $withTrashed,
            $softDays,
            $hardDays
        );
    }

    /**
     * @return ProjectDto[]
     */
    private function makeRecords(int ...$objectIds): array
    {
        return array_map(
            static function (int $objectId): ProjectDto {
                $project = new ProjectDto();
                $project->setObjectId($objectId);

                return $project;
            },
            $objectIds
        );
    }

    /**
     * @param object[] $records
     * @return int[]
     */
    private function objectIds(array $records): array
    {
        return array_map(static fn(object $record): int => $record->getObjectId(), $records);
    }
}
