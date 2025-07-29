<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wtl\HioTypo3Connector\Services\HioMiddlewareRequestImportService;
use Wtl\HioTypo3Connector\Trait\WithConfigureRequestImportCommandTrait;

class RequestHioImportCommand extends Command
{
    use WithConfigureRequestImportCommandTrait;
    protected const REQUESTED_ENTITY_TYPE = '';

    protected static $defaultName = '';

    public function __construct(protected readonly HioMiddlewareRequestImportService $hioMiddlewareRequestImportService)
    {
        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->hioMiddlewareRequestImportService->configure(
            $input->getArgument('api-url'),
            $input->getArgument('api-username'),
            $input->getArgument('api-password'),
            $input->getOption('api-verify-ssl'),
            $input->getArgument('t3-webhook-url'),
            $input->getArgument('t3-x-api-key'),
            (int)$input->getArgument('t3-batch-size'),
        );

        $response = $this->hioMiddlewareRequestImportService->requestImport(static::REQUESTED_ENTITY_TYPE);
        if ($response->getStatusCode() !== 200) {
            $output->writeln('Error requesting data import from HIO Middleware API: ' . $response->getBody());
            return Command::FAILURE;
        }
        $output->writeln('Data import requested successfully.');
        return Command::SUCCESS;
    }
}
