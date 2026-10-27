<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Command;

use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Event\ReceiveHioPatentEvent;
use Wtl\HioTypo3Connector\Services\HioPatentService;
use Wtl\HioTypo3Connector\Services\RecordLifecycle\RecordLifecycleService;
use Wtl\HioTypo3Connector\Trait\WithConfigureImportCommandTrait;

class PatentsImportCommand extends Command
{
    use WithConfigureImportCommandTrait;

    protected static $defaultName = 'hio:patents:import';

    public function __construct(
        private readonly HioPatentService $hioPatentService,
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
        $this->hioPatentService->configure(
            $input->getArgument('endpoint'),
            $input->getArgument('username'),
            $input->getArgument('password'),
            $input->getArgument('storagePageId'),
            (bool)$input->getOption('verify-ssl'),
            (bool)$input->getOption('no-basic-auth')
        );
        $recordLifecycle = $this->recordLifecycleService->startRun(
            $this->hioPatentService,
            'tx_hiotypo3connector_domain_model_patent',
            $input
        );

        $currentPage = 1;
        do {
            /** @var PatentDto[] $patents */
            $patents = $this->hioPatentService->getPatents($currentPage);
            if ($this->hioPatentService->getMeta()->getTotal() === 0) {
                $output->writeln('No new patents found');
                return Command::SUCCESS;
            }
            $patents = $recordLifecycle->beforeDispatch($patents);

            foreach ($patents as $patent) {
                $this->eventDispatcher->dispatch(
                    new ReceiveHioPatentEvent($patent, (int)$input->getArgument('storagePageId'))
                );
            }

            $recordLifecycle->afterDispatch();

            $currentPage++;
        } while ($currentPage <= $this->hioPatentService->getMeta()->getLastPage());

        $recordLifecycle->finish($output, 'Patents');
        return Command::SUCCESS;
    }
}
