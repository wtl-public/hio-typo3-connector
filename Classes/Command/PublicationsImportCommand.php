<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\PublicationRepository;
use Wtl\HioTypo3Connector\Services\HioPublicationService;

class PublicationsImportCommand extends Command
{
    protected static $defaultName = 'hio:publications:import';

    public function __construct(
        private readonly PublicationRepository $publicationRepository,
        private readonly HioPublicationService $hioPublicationService,
        protected readonly PersistenceManager $persistenceManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Import publications from HIO')
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
        $this->hioPublicationService->configure(
            $input->getArgument('endpoint'),
            $input->getArgument('username'),
            $input->getArgument('password'),
            $input->getArgument('storagePageId')
        );

        $querySettings = $this->publicationRepository->createQuery()->getQuerySettings()->setStoragePageIds([$input->getArgument('storagePageId')]);
        $this->publicationRepository->setDefaultQuerySettings($querySettings);

        $currentPage = 1;
        do {
            $publications = $this->hioPublicationService->getPublications($currentPage);
            if ($this->hioPublicationService->getMeta()->getTotal() === 0) {
                $output->writeln('No new publications found');
                return Command::SUCCESS;
            }

            $this->publicationRepository->savePublications($publications, $input->getArgument('storagePageId'));

            $currentPage++;
        } while ($currentPage <= $this->hioPublicationService->getMeta()->getLastPage());

        $output->writeln($this->hioPublicationService->getMeta()->getTotal() . ' Publications imported successfully');
        return Command::SUCCESS;
    }
}
