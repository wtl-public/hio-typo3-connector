<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\PersonRepository;
use Wtl\HioTypo3Connector\Services\HioPersonService;

class PersonsImportCommand extends Command
{
    protected static $defaultName = 'hio:persons:import';

    public function __construct(
        private readonly PersonRepository $personRepository,
        private readonly HioPersonService $hioPersonService,
        protected readonly PersistenceManager $persistenceManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Import persons from HIO')
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
        $this->hioPersonService->configure(
            $input->getArgument('endpoint'),
            $input->getArgument('username'),
            $input->getArgument('password'),
            $input->getArgument('storagePageId')
        );

        $querySettings = $this->personRepository->createQuery()->getQuerySettings()->setStoragePageIds([$input->getArgument('storagePageId')]);
        $this->personRepository->setDefaultQuerySettings($querySettings);

        $currentPage = 1;
        do {
            $persons = $this->hioPersonService->getPersons($currentPage);
            if ($this->hioPersonService->getMeta()->getTotal() === 0) {
                $output->writeln('No new persons found');
                return Command::SUCCESS;
            }

            $this->personRepository->savePersons($persons, $input->getArgument('storagePageId'));

            $currentPage++;
        } while ($currentPage <= $this->hioPersonService->getMeta()->getLastPage());

        $output->writeln($this->hioPersonService->getMeta()->getTotal() . ' Persons imported successfully');
        return Command::SUCCESS;
    }
}
