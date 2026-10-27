<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Command;

use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Event\ReceiveHioHabilitationEvent;
use Wtl\HioTypo3Connector\Services\HioHabilitationService;
use Wtl\HioTypo3Connector\Services\RecordLifecycle\RecordLifecycleService;
use Wtl\HioTypo3Connector\Trait\WithConfigureImportCommandTrait;

class HabilitationsImportCommand extends Command
{
    use WithConfigureImportCommandTrait;

    protected static $defaultName = 'hio:habilitations:import';

    public function __construct(
        protected readonly HioHabilitationService   $hioHabilitationService,
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
        $this->hioHabilitationService->configure(
            $input->getArgument('endpoint'),
            $input->getArgument('username'),
            $input->getArgument('password'),
            $input->getArgument('storagePageId'),
            (bool)$input->getOption('verify-ssl'),
            (bool)$input->getOption('no-basic-auth')
        );
        $recordLifecycle = $this->recordLifecycleService->startRun(
            $this->hioHabilitationService,
            'tx_hiotypo3connector_domain_model_habilitation',
            $input
        );

        $currentPage = 1;
        do {
            /** @var HabilitationDto[] $habilitations */
            $habilitations = $this->hioHabilitationService->getHabilitations($currentPage);
            if ($this->hioHabilitationService->getMeta()->getTotal() === 0) {
                $output->writeln('No new habilitations found');
                return Command::SUCCESS;
            }
            $habilitations = $recordLifecycle->beforeDispatch($habilitations);

            foreach ($habilitations as $habilitation) {
                $this->eventDispatcher->dispatch(
                    new ReceiveHioHabilitationEvent($habilitation, (int)$input->getArgument('storagePageId'))
                );
            }

            $recordLifecycle->afterDispatch();

            $currentPage++;
        } while ($currentPage <= $this->hioHabilitationService->getMeta()->getLastPage());

        $recordLifecycle->finish($output, 'Habilitations');
        return Command::SUCCESS;
    }
}
