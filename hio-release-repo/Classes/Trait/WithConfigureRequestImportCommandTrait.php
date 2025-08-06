<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

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
                'optional argument: basic auth username'
            )->addArgument(
                'api-password',
                InputArgument::OPTIONAL,
                'optional argument: basic auth password'
            )->addOption(
                'api-verify-ssl',
                null,
                InputOption::VALUE_NONE,
                'optional argument: verify API ssl certificate (default: false)'
            );
    }
}
