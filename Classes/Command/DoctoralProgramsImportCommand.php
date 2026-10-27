<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Command;

use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Event\ReceiveHioDoctoralProgramEvent;
use Wtl\HioTypo3Connector\Services\HioDoctoralProgramService;
use Wtl\HioTypo3Connector\Services\RecordLifecycle\RecordLifecycleService;
use Wtl\HioTypo3Connector\Trait\WithConfigureImportCommandTrait;

class DoctoralProgramsImportCommand extends Command
{
    use WithConfigureImportCommandTrait;

    protected static $defaultName = 'hio:doctoralPrograms:import';

    public function __construct(
        protected readonly HioDoctoralProgramService $hioDoctoralProgramService,
        protected readonly EventDispatcherInterface  $eventDispatcher,
        private readonly RecordLifecycleService $recordLifecycleService)
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
        $this->hioDoctoralProgramService->configure(
            $input->getArgument('endpoint'),
            $input->getArgument('username'),
            $input->getArgument('password'),
            $input->getArgument('storagePageId'),
            (bool)$input->getOption('verify-ssl'),
            (bool)$input->getOption('no-basic-auth')
        );
        $recordLifecycle = $this->recordLifecycleService->startRun(
            $this->hioDoctoralProgramService,
            'tx_hiotypo3connector_domain_model_doctoralprogram',
            $input
        );

        $currentPage = 1;
        do {
            $doctoralPrograms = $this->hioDoctoralProgramService->getDoctoralPrograms($currentPage);
            if ($this->hioDoctoralProgramService->getMeta()->getTotal() === 0) {
                $output->writeln('No new doctoral programs found');
                return Command::SUCCESS;
            }
            $doctoralPrograms = $recordLifecycle->beforeDispatch($doctoralPrograms);

            foreach ($doctoralPrograms as $doctoralProgram) {
                $this->eventDispatcher->dispatch(
                    new ReceiveHioDoctoralProgramEvent($doctoralProgram, (int)$input->getArgument('storagePageId'))
                );
            }

            $recordLifecycle->afterDispatch();

            $currentPage++;
        } while ($currentPage <= $this->hioDoctoralProgramService->getMeta()->getLastPage());

        $recordLifecycle->finish($output, 'doctoral programs');
        return Command::SUCCESS;
    }
}
