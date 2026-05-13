<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\Search;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Search\UmlautSearchVariantBuilder;

#[CoversClass(UmlautSearchVariantBuilder::class)]
final class UmlautSearchVariantBuilderTest extends UnitTestCase
{
    private UmlautSearchVariantBuilder $builder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->builder = new UmlautSearchVariantBuilder();
    }

    #[Test]
    #[DataProvider('variantsProvider')]
    public function buildVariants_returnsExpectedVariants(string $input, array $expected): void
    {
        self::assertEqualsCanonicalizing($expected, $this->builder->buildVariants($input));
    }

    #[Test]
    public function buildVariants_withOneWayMap_appliesOneWayOnAllVariants(): void
    {
        $builder = new UmlautSearchVariantBuilder(
            charMap:   ['ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue'],
            oneWayMap: ['ñ' => 'n'],
        );

        $variants = $builder->buildVariants('coeño');

        // ñ→n on all variants
        self::assertContains('coeño', $variants);  // original
        self::assertContains('cöño',  $variants);  // oe→ö
        self::assertContains('coeno', $variants);  // ñ→n
        self::assertContains('cöno',  $variants);  // oe→ö + ñ→n

        // n→ñ must not exist (e.g. "berlin" → "berlñ")
        foreach ($variants as $v) {
            self::assertStringNotContainsString('berlñ',
                str_replace('coeño', '', $v),
                'n→ñ must not exist'
            );
        }
    }

    public static function variantsProvider(): array
    {
        return [
            'Vößler – ö and ß' => [
                'input'    => 'Vößler',
                'expected' => [
                    'vößler',   // original
                    'voessler', // ö→oe, ß→ss (ascii)
                    'voeßler',  // ö→oe, ß bleibt (asciiUmlautOnly)
                    'vössler',  // ß→ss (szToSs)
                ],
            ],
            'Vössler – ö and ss' => [
                'input'    => 'Vössler',
                'expected' => [
                    'vößler',   // original
                    'voessler', // ö→oe, ß→ss (ascii)
                    'voeßler',  // ö→oe, ß bleibt (asciiUmlautOnly)
                    'vössler',  // ß→ss (szToSs)
                ],
            ],
            'voessler – oe and ss' => [
                'input'    => 'voessler',
                'expected' => [
                    'voessler', // original
                    'vössler',  // oe→ö (umlaut)
                    'voeßler',  // ss→ß (ssToSz)
                    'vößler',   // oe→ö + ss→ß (umlaut + ssToSz)
                ],
            ],
            'voeßler – oe and ß' => [
                'input'    => 'voeßler',
                'expected' => [
                    'voessler', // original
                    'vössler',  // oe→ö (umlaut)
                    'voeßler',  // ss→ß (ssToSz)
                    'vößler',   // oe→ö + ss→ß (umlaut + ssToSz)
                ],
            ],
            'mueller – ue, no ß/ss' => [
                'input'    => 'mueller',
                'expected' => [
                    'mueller',
                    'müller',   // ue→ü
                ],
            ],
            'Müller – ü' => [
                'input'    => 'Müller',
                'expected' => [
                    'müller',
                    'mueller',  // ü→ue
                ],
            ],
            'strasse – ss no Umlaut' => [
                'input'    => 'strasse',
                'expected' => [
                    'strasse',
                    'straße',   // ss→ß
                ],
            ],
            'straße – ß' => [
                'input'    => 'straße',
                'expected' => [
                    'straße',
                    'strasse',  // ß→ss
                ],
            ],
            'no Umlaut and no ß' => [
                'input'    => 'berlin',
                'expected' => ['berlin'],
            ],
            'empty string to trim' => [
                'input'    => '   ',
                'expected' => [''],
            ],
        ];
    }
}

