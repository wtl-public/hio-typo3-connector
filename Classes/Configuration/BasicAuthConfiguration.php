<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Configuration;

final class BasicAuthConfiguration
{
    private const ENV_USERNAME = 'HIO_TYPO3_CONNECTOR_BASIC_AUTH_USERNAME';
    private const ENV_PASSWORD = 'HIO_TYPO3_CONNECTOR_BASIC_AUTH_PASSWORD';

    /**
     * @return list<string>
     */
    public function resolve(string $username, string $password, bool $disableBasicAuth = false): array
    {
        if ($disableBasicAuth) {
            return [];
        }

        if ($username !== '' && $password !== '') {
            return [$username, $password];
        }

        $envUsername = $this->getenv(self::ENV_USERNAME);
        $envPassword = $this->getenv(self::ENV_PASSWORD);

        if ($envUsername !== '' && $envPassword !== '') {
            return [$envUsername, $envPassword];
        }

        return [];
    }

    private function getenv(string $name): string
    {
        $value = getenv($name);

        return is_string($value) ? $value : '';
    }
}
