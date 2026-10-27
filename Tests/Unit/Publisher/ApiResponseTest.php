<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\Publisher;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Wtl\HioTypo3Connector\Publisher\ApiResponse;

/**
 * Unit tests for ApiResponse.
 *
 * Covers how a page of the middleware response is split into live records
 * (getData / getLastSeen) and trashed records (getTrashed), as delivered
 * with filter[trashed]=with, and how their dates become unix timestamps.
 */
#[CoversClass(ApiResponse::class)]
final class ApiResponseTest extends TestCase
{
    private const LAST_SEEN_AT = 1768032000; // 2026-01-10T08:00:00+00:00
    private const DELETED_AT = 1767960000; // 2026-01-09T12:00:00+00:00

    #[Test]
    public function trashedRowsAreReturnedByGetTrashedAndNotByGetData(): void
    {
        $response = new ApiResponse(
            [
                ['id' => 2, 'deletedAt' => '2026-01-09T12:00:00+00:00'],
                ['id' => 1, 'title' => 'Live', 'lastSeenAt' => '2026-01-10T08:00:00+00:00'],
            ],
            $this->makeMeta(),
            []
        );

        self::assertSame([2 => self::DELETED_AT], $response->getTrashed());
        self::assertSame(
            [['id' => 1, 'title' => 'Live', 'lastSeenAt' => '2026-01-10T08:00:00+00:00']],
            $response->getData()
        );
    }

    #[Test]
    public function getLastSeenMapsLiveObjectIdsToLastSeenAtAndNullWhenMissing(): void
    {
        $response = new ApiResponse(
            [
                ['id' => 1, 'lastSeenAt' => '2026-01-10T08:00:00+00:00'],
                ['id' => 2],
                ['id' => 3, 'deletedAt' => '2026-01-09T12:00:00+00:00'],
            ],
            $this->makeMeta(),
            []
        );

        self::assertSame([1 => self::LAST_SEEN_AT, 2 => null], $response->getLastSeen());
    }

    #[Test]
    public function nullDataResultsInEmptyArrays(): void
    {
        $response = new ApiResponse(null, $this->makeMeta(), null);

        self::assertSame([], $response->getData());
        self::assertSame([], $response->getTrashed());
        self::assertSame([], $response->getLastSeen());
    }

    /**
     * Meta block in the middleware's (Laravel paginator) key order, which ApiResponse relies on.
     */
    private function makeMeta(): array
    {
        return [
            'current_page' => 1,
            'from' => 1,
            'last_page' => 1,
            'links' => [],
            'path' => 'https://middleware.example/api/projects',
            'per_page' => 25,
            'to' => 1,
            'total' => 1,
        ];
    }
}
