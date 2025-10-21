<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Command;

use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Dto\NominationDto;
use Wtl\HioTypo3Connector\Event\ReceiveHioNominationEvent;
use Wtl\HioTypo3Connector\Services\HioNominationService;
use Wtl\HioTypo3Connector\Trait\WithConfigureImportCommandTrait;

class NominationsImportCommand extends Command
{
    use WithConfigureImportCommandTrait;

    protected static $defaultName = 'hio:nominations:import';

    public function __construct(
        private readonly HioNominationService $nominationService,
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
        $this->nominationService->configure(
            $input->getArgument('endpoint'),
            $input->getArgument('username'),
            $input->getArgument('password'),
            $input->getArgument('storagePageId'),
            (bool)$input->getOption('verify-ssl')
        );

        $currentPage = 1;
        do {
            /** @var NominationDto[] $orgUnits */
            $nominations = $this->nominationService->getNominations($currentPage);
            if ($this->nominationService->getMeta()->getTotal() === 0) {
                $output->writeln('No new nominations found');
                return Command::SUCCESS;
            }

            foreach ($nominations as $nomination) {
                $this->eventDispatcher->dispatch(
                    new ReceiveHioNominationEvent($nomination, (int)$input->getArgument('storagePageId'))
                );
            }

            $currentPage++;
        } while ($currentPage <= $this->nominationService->getMeta()->getLastPage());

        $output->writeln($this->nominationService->getMeta()->getTotal() . ' Nominations imported successfully');
        return Command::SUCCESS;
    }
}
