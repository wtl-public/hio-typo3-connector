<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\HabilitationRepository;
use Wtl\HioTypo3Connector\Services\HioHabilitationService;

class HabilitationsImportCommand extends Command
{
    protected static $defaultName = 'hio:doctorates:import';

    public function __construct(
        private readonly HabilitationRepository $habilitationRepository,
        private readonly HioHabilitationService $hioHabilitationService,
        protected readonly PersistenceManager   $persistenceManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Import habilitations from HIO')
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
        $this->hioHabilitationService->configure(
            $input->getArgument('endpoint'),
            $input->getArgument('username'),
            $input->getArgument('password'),
            $input->getArgument('storagePageId')
        );

        $querySettings = $this->habilitationRepository->createQuery()->getQuerySettings()->setStoragePageIds([$input->getArgument('storagePageId')]);
        $this->habilitationRepository->setDefaultQuerySettings($querySettings);

        $currentPage = 1;
        do {
            $habilitations = $this->hioHabilitationService->getHabilitations($currentPage);
            if ($this->hioHabilitationService->getMeta()->getTotal() === 0) {
                $output->writeln('No new habilitations found');
                return Command::SUCCESS;
            }

            $this->habilitationRepository->saveHabilitations($habilitations, $input->getArgument('storagePageId'));

            $currentPage++;
        } while ($currentPage <= $this->hioHabilitationService->getMeta()->getLastPage());

        $output->writeln($this->hioHabilitationService->getMeta()->getTotal() . ' Habilitations imported successfully');
        return Command::SUCCESS;
    }
}
