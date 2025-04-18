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
use Wtl\HioTypo3Connector\Trait\WithConfigureImportCommandTrait;

class ProjectsImportCommand extends Command
{
    use WithConfigureImportCommandTrait;

    protected static $defaultName = 'hio:projects:import';

    public function __construct(
        private readonly HioProjectService $hioProjectService,
        protected readonly EventDispatcherInterface $eventDispatcher)
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
            (bool)$input->getOption('verify-ssl')
        );

        $currentPage = 1;
        do {
            /** @var ProjectDto[] $projects */
            $projects = $this->hioProjectService->getProjects($currentPage);
            if ($this->hioProjectService->getMeta()->getTotal() === 0) {
                $output->writeln('No new projects found');
                return Command::SUCCESS;
            }

            foreach ($projects as $project) {
                $this->eventDispatcher->dispatch(
                    new ReceiveHioProjectEvent($project, $input->getArgument('storagePageId'))
                );
            }

            $currentPage++;
        } while ($currentPage <= $this->hioProjectService->getMeta()->getLastPage());

        $output->writeln($this->hioProjectService->getMeta()->getTotal() . ' Projects imported successfully');
        return Command::SUCCESS;
    }
}
