<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

trait WithConfigureImportCommandTrait
{
    protected function configure(): void {
        $this->setDescription('Import data from HIO')
            ->addArgument(
                'endpoint',
                InputArgument::REQUIRED,
                'required argument: endpoint (the url to call)'
            )->addArgument(
                'storagePageId',
                InputArgument::REQUIRED,
                'required argument: storage page id'
            )->addArgument(
                'username',
                InputArgument::OPTIONAL,
                $this->translateCommandLabel(
                    'scheduler.import.argument.username.description',
                    'optional argument: basic auth username. Leave empty to use HIO_TYPO3_CONNECTOR_BASIC_AUTH_USERNAME from .env if configured.'
                ),
                ''
            )->addArgument(
                'password',
                InputArgument::OPTIONAL,
                $this->translateCommandLabel(
                    'scheduler.import.argument.password.description',
                    'optional argument: basic auth password. Leave empty to use HIO_TYPO3_CONNECTOR_BASIC_AUTH_PASSWORD from .env if configured.'
                ),
                ''
            )->addOption(
                'no-basic-auth',
                null,
                InputOption::VALUE_NONE,
                $this->translateCommandLabel(
                    'scheduler.import.option.noBasicAuth.description',
                    'optional argument: disable BasicAuth for this task. If set, scheduler and .env credentials are ignored.'
                )
            )->addOption(
                'verify-ssl',
                'vs',
                InputOption::VALUE_NONE,
                'optional argument: verify API ssl certificate'
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
