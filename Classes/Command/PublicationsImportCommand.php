<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Command;

use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Dto\PublicationDto;
use Wtl\HioTypo3Connector\Domain\Repository\CitationStyleRepository;
use Wtl\HioTypo3Connector\Event\ReceiveHioPublicationEvent;
use Wtl\HioTypo3Connector\Services\HioPublicationService;

class PublicationsImportCommand extends Command
{
    use WithConfigureImportCommandTrait;

    protected static $defaultName = 'hio:publications:import';

    public function __construct(
        private readonly HioPublicationService $hioPublicationService,
        protected readonly CitationStyleRepository $citationStyleRepository,
        protected readonly EventDispatcherInterface $eventDispatcher
    )
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
        $this->hioPublicationService->configure(
            $input->getArgument('endpoint'),
            $input->getArgument('username'),
            $input->getArgument('password'),
            $input->getArgument('storagePageId'),
            (bool)$input->getOption('verify-ssl')
        );

        $currentPage = 1;
        $firstPublication = null;
        do {
            /** @var PublicationDto[] $publications */
            $publications = $this->hioPublicationService->getPublications($currentPage);
            if ($this->hioPublicationService->getMeta()->getTotal() === 0) {
                $output->writeln('No new publications found');
                return Command::SUCCESS;
            }
            if ($firstPublication === null) {
                $firstPublication = $publications[0];
            }

            foreach ($publications as $publication) {
                $this->eventDispatcher->dispatch(
                    new ReceiveHioPublicationEvent($publication, (int)$input->getArgument('storagePageId')),
                );
            }

            $currentPage++;
        } while ($currentPage <= $this->hioPublicationService->getMeta()->getLastPage());

        if ($firstPublication !== null) {
            $this->citationStyleRepository->saveCitationStyles($firstPublication->getCitations());
        }

        $output->writeln($this->hioPublicationService->getMeta()->getTotal() . ' Publications imported successfully');
        return Command::SUCCESS;
    }
}
