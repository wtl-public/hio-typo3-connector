<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Command;

use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Dto\PersonDto;
use Wtl\HioTypo3Connector\Event\ReceiveHioPersonEvent;
use Wtl\HioTypo3Connector\Services\HioPersonService;
use Wtl\HioTypo3Connector\Services\RecordLifecycle\RecordLifecycleService;
use Wtl\HioTypo3Connector\Trait\WithConfigureImportCommandTrait;

class PersonsImportCommand extends Command
{
    use WithConfigureImportCommandTrait;

    protected static $defaultName = 'hio:persons:import';

    public function __construct(
        protected readonly HioPersonService $hioPersonService,
        protected readonly EventDispatcherInterface $eventDispatcher,
        private readonly RecordLifecycleService $recordLifecycleService
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
        $this->hioPersonService->configure(
            $input->getArgument('endpoint'),
            $input->getArgument('username'),
            $input->getArgument('password'),
            $input->getArgument('storagePageId'),
            (bool)$input->getOption('verify-ssl'),
            (bool)$input->getOption('no-basic-auth')
        );
        $recordLifecycle = $this->recordLifecycleService->startRun(
            $this->hioPersonService,
            'tx_hiotypo3connector_domain_model_person',
            $input
        );

        $currentPage = 1;
        do {
            /** @var PersonDto[] $persons */
            $persons = $this->hioPersonService->getPersons($currentPage);
            if ($this->hioPersonService->getMeta()->getTotal() === 0) {
                $output->writeln('No new persons found');
                return Command::SUCCESS;
            }
            $persons = $recordLifecycle->beforeDispatch($persons);

            foreach ($persons as $person) {
                $this->eventDispatcher->dispatch(
                    new ReceiveHioPersonEvent($person, (int)$input->getArgument('storagePageId')),
                );
            }

            $recordLifecycle->afterDispatch();

            $currentPage++;
        } while ($currentPage <= $this->hioPersonService->getMeta()->getLastPage());

        $recordLifecycle->finish($output, 'Persons');
        return Command::SUCCESS;
    }
}
