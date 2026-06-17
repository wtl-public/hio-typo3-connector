<?php

namespace Unit\Utility;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Wtl\HioTypo3Connector\Utility\DataUtility;

class DataUtilityTest extends TestCase
{
    public static function coerceStringProvider(): array
    {
        return [
            'string value' => ['Germany', 'name', null, 'Germany'],
            'array with name key' => [['name' => 'Germany'], 'name', null, 'Germany'],
            'array with custom key' => [['label' => 'Germany'], 'label', null, 'Germany'],
            'null uses fallback' => [null, 'name', 'unknown', 'unknown'],
            'null without fallback' => [null, 'name', null, null],
            'array missing key uses fallback' => [['iso' => 'DE'], 'name', 'unknown', 'unknown'],
            'empty string' => ['', 'name', null, ''],
        ];
    }

    #[Test]
    #[DataProvider('coerceStringProvider')]
    public function coerceString(mixed $value, string $key, ?string $fallback, ?string $expected): void
    {
        self::assertSame($expected, DataUtility::coerceString($value, $key, $fallback));
    }
}