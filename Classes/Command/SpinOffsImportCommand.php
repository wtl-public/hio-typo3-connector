<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Command;

use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Dto\SpinOffDto;
use Wtl\HioTypo3Connector\Event\ReceiveHioSpinOffEvent;
use Wtl\HioTypo3Connector\Services\HioSpinOffService;
use Wtl\HioTypo3Connector\Services\RecordLifecycle\RecordLifecycleService;
use Wtl\HioTypo3Connector\Trait\WithConfigureImportCommandTrait;

class SpinOffsImportCommand extends Command
{
    use WithConfigureImportCommandTrait;

    protected static $defaultName = 'hio:spinoffs:import';

    public function __construct(
        private readonly HioSpinOffService $service,
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
        $this->service->configure(
            $input->getArgument('endpoint'),
            $input->getArgument('username'),
            $input->getArgument('password'),
            $input->getArgument('storagePageId'),
            (bool)$input->getOption('verify-ssl'),
            (bool)$input->getOption('no-basic-auth')
        );
        $recordLifecycle = $this->recordLifecycleService->startRun(
            $this->service,
            'tx_hiotypo3connector_domain_model_spinoff',
            $input
        );

        $currentPage = 1;
        do {
            /** @var SpinOffDto[] $spinOffs */
            $spinOffs = $this->service->getSpinOffs($currentPage);
            if ($this->service->getMeta()->getTotal() === 0) {
                $output->writeln('No new spin-offs found');
                return Command::SUCCESS;
            }
            $spinOffs = $recordLifecycle->beforeDispatch($spinOffs);

            foreach ($spinOffs as $spinOff) {
                $this->eventDispatcher->dispatch(
                    new ReceiveHioSpinOffEvent($spinOff, (int)$input->getArgument('storagePageId'))
                );
            }

            $recordLifecycle->afterDispatch();

            $currentPage++;
        } while ($currentPage <= $this->service->getMeta()->getLastPage());

        $recordLifecycle->finish($output, 'spin-offs');
        return Command::SUCCESS;
    }
}
