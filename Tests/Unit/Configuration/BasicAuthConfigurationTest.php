<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\Configuration;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Wtl\HioTypo3Connector\Configuration\BasicAuthConfiguration;

final class BasicAuthConfigurationTest extends TestCase
{
    private BasicAuthConfiguration $configuration;

    protected function setUp(): void
    {
        parent::setUp();
        $this->configuration = new BasicAuthConfiguration();
        $this->clearEnvironment();
    }

    protected function tearDown(): void
    {
        $this->clearEnvironment();
        parent::tearDown();
    }

    #[Test]
    public function resolveUsesSchedulerCredentialsFirst(): void
    {
        putenv('HIO_TYPO3_CONNECTOR_BASIC_AUTH_USERNAME=env-user');
        putenv('HIO_TYPO3_CONNECTOR_BASIC_AUTH_PASSWORD=env-password');

        self::assertSame(
            ['scheduler-user', 'scheduler-password'],
            $this->configuration->resolve('scheduler-user', 'scheduler-password')
        );
    }

    #[Test]
    public function resolveFallsBackToEnvironmentCredentials(): void
    {
        putenv('HIO_TYPO3_CONNECTOR_BASIC_AUTH_USERNAME=env-user');
        putenv('HIO_TYPO3_CONNECTOR_BASIC_AUTH_PASSWORD=env-password');

        self::assertSame(
            ['env-user', 'env-password'],
            $this->configuration->resolve('', '')
        );
    }

    #[Test]
    public function resolveReturnsEmptyArrayWithoutCompleteCredentials(): void
    {
        putenv('HIO_TYPO3_CONNECTOR_BASIC_AUTH_USERNAME=env-user');

        self::assertSame([], $this->configuration->resolve('', ''));
    }

    #[Test]
    public function resolveReturnsEmptyArrayWhenBasicAuthIsDisabled(): void
    {
        putenv('HIO_TYPO3_CONNECTOR_BASIC_AUTH_USERNAME=env-user');
        putenv('HIO_TYPO3_CONNECTOR_BASIC_AUTH_PASSWORD=env-password');

        self::assertSame(
            [],
            $this->configuration->resolve('scheduler-user', 'scheduler-password', true)
        );
    }

    private function clearEnvironment(): void
    {
        putenv('HIO_TYPO3_CONNECTOR_BASIC_AUTH_USERNAME');
        putenv('HIO_TYPO3_CONNECTOR_BASIC_AUTH_PASSWORD');
    }
}
