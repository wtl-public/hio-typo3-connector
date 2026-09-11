<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

trait WithConfigureRequestImportCommandTrait
{
    protected function configure(): void {
        $this->setDescription('Import data from HIO')
            ->addArgument(
                'api-url',
                InputArgument::REQUIRED,
                'required argument: Middleware API-Endpoint URl'
            )->addArgument(
                't3-webhook-url',
                InputArgument::REQUIRED,
                'required argument: TYPO3 webhook Url (the url to receive publications)'
            )->addArgument(
                't3-x-api-key',
                InputArgument::REQUIRED,
                'required argument: x-api-key'
            )->addArgument(
                't3-batch-size',
                InputArgument::OPTIONAL,
                'optional argument: batch size (default: 100)',
                100
            )->addArgument(
                'api-username',
                InputArgument::OPTIONAL,
                $this->translateCommandLabel(
                    'scheduler.requestImport.argument.apiUsername.description',
                    'optional argument: API BasicAuth username. Leave empty to use HIO_TYPO3_CONNECTOR_BASIC_AUTH_USERNAME from .env if configured.'
                ),
                ''
            )->addArgument(
                'api-password',
                InputArgument::OPTIONAL,
                $this->translateCommandLabel(
                    'scheduler.requestImport.argument.apiPassword.description',
                    'optional argument: API BasicAuth password. Leave empty to use HIO_TYPO3_CONNECTOR_BASIC_AUTH_PASSWORD from .env if configured.'
                ),
                ''
            )->addOption(
                'api-no-basic-auth',
                null,
                InputOption::VALUE_NONE,
                $this->translateCommandLabel(
                    'scheduler.requestImport.option.apiNoBasicAuth.description',
                    'optional argument: disable API BasicAuth for this task. If set, scheduler and .env credentials are ignored.'
                )
            )->addOption(
                'api-verify-ssl',
                null,
                InputOption::VALUE_NONE,
                'optional argument: verify API ssl certificate (default: false)'
            );
    }

    private function translateCommandLabel(string $id, string $fallback): string
    {
        return LocalizationUtility::translate(
            'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:' . $id,
            'hio_typo3_connector'
        ) ?? $fallback;
    }
}
