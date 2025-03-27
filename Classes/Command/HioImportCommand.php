<?php

namespace Wtl\HioTypo3Connector\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class HioImportCommand extends Command
{
    protected function configure(): void {
        $this->setDescription('Import data from HIO')
            ->addArgument(
                'endpoint',
                InputArgument::REQUIRED,
                'required argument endpoint (the url to call)'
            )->addArgument(
                'username',
                InputArgument::OPTIONAL,
                'required argument basic auth username'
            )->addArgument(
                'password',
                InputArgument::OPTIONAL,
                'required argument basic auth password'
            )->addArgument(
                'storagePageId',
                InputArgument::REQUIRED,
                'required argument storage page id'
            )->addOption(
                'verify-ssl',
                InputArgument::OPTIONAL,
                'verify ssl certificate',
                true
            );
    }
}
