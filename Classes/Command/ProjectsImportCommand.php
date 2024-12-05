<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\ProjectRepository;
use Wtl\HioTypo3Connector\Services\HioProjectService;

class ProjectsImportCommand extends Command
{
    protected static $defaultName = 'hio:projects:import';

    public function __construct(
        private readonly ProjectRepository $projectRepository,
        private readonly HioProjectService $hioProjectService,
        protected readonly PersistenceManager $persistenceManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Import projects from HIO')
            ->addArgument(
                'endpoint',
                InputArgument::REQUIRED,
                'required argument endpoint (the url to call)'
            )->addArgument(
                'username',
                InputArgument::REQUIRED,
                'required argument basic auth username'
            )->addArgument(
                'password',
                InputArgument::REQUIRED,
                'required argument basic auth password'
            )->addArgument(
                'storagePageId',
                InputArgument::REQUIRED,
                'required argument storage page id'
            );
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
            $input->getArgument('storagePageId')
        );

        $querySettings = $this->projectRepository->createQuery()->getQuerySettings()->setStoragePageIds([$input->getArgument('storagePageId')]);
        $this->projectRepository->setDefaultQuerySettings($querySettings);

        $currentPage = 1;
        do {
            $projects = $this->hioProjectService->getProjects($currentPage);
            if ($this->hioProjectService->getMeta()->getTotal() === 0) {
                $output->writeln('No new projects found');
                return Command::SUCCESS;
            }

            $this->projectRepository->saveProjects($projects, $input->getArgument('storagePageId'));

            $currentPage++;
        } while ($currentPage <= $this->hioProjectService->getMeta()->getLastPage());

        $output->writeln($this->hioProjectService->getMeta()->getTotal() . ' Projects imported successfully');
        return Command::SUCCESS;
    }
}
