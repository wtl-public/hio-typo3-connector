<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Command;

use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Event\ReceiveHioProjectEvent;
use Wtl\HioTypo3Connector\Services\HioProjectService;
use Wtl\HioTypo3Connector\Services\RecordLifecycle\RecordLifecycleService;
use Wtl\HioTypo3Connector\Trait\WithConfigureImportCommandTrait;

class ProjectsImportCommand extends Command
{
    use WithConfigureImportCommandTrait;

    protected static $defaultName = 'hio:projects:import';

    public function __construct(
        private readonly HioProjectService $hioProjectService,
        protected readonly EventDispatcherInterface $eventDispatcher,
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
        $this->hioProjectService->configure(
            $input->getArgument('endpoint'),
            $input->getArgument('username'),
            $input->getArgument('password'),
            $input->getArgument('storagePageId'),
            (bool)$input->getOption('verify-ssl'),
            (bool)$input->getOption('no-basic-auth')
        );
        $recordLifecycle = $this->recordLifecycleService->startRun(
            $this->hioProjectService,
            'tx_hiotypo3connector_domain_model_project',
            $input
        );

        $currentPage = 1;
        do {
            /** @var ProjectDto[] $projects */
            $projects = $this->hioProjectService->getProjects($currentPage);
            if ($this->hioProjectService->getMeta()->getTotal() === 0) {
                $output->writeln('No new projects found');
                return Command::SUCCESS;
            }
            $projects = $recordLifecycle->beforeDispatch($projects);

            foreach ($projects as $project) {
                $this->eventDispatcher->dispatch(
                    new ReceiveHioProjectEvent($project, (int)$input->getArgument('storagePageId'))
                );
            }

            $recordLifecycle->afterDispatch();

            $currentPage++;
        } while ($currentPage <= $this->hioProjectService->getMeta()->getLastPage());

        $recordLifecycle->finish($output, 'Projects');
        return Command::SUCCESS;
    }
}
