<?php

namespace Wtl\HioTypo3Connector\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class HioImportCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

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
                'optional argument: basic auth username'
            )->addArgument(
                'password',
                InputArgument::OPTIONAL,
                'optional argument: basic auth password'
            )->addOption(
                'verify-ssl',
                'v',
                InputOption::VALUE_NONE,
                'optional argument: verify API ssl certificate'
            );
    }
}
