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
use Wtl\HioTypo3Connector\Trait\WithConfigureImportCommandTrait;

class SpinOffsImportCommand extends Command
{
    use WithConfigureImportCommandTrait;

    protected static $defaultName = 'hio:spinoffs:import';

    public function __construct(
        private readonly HioSpinOffService $spinOffService,
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
        $this->spinOffService->configure(
            $input->getArgument('endpoint'),
            $input->getArgument('username'),
            $input->getArgument('password'),
            $input->getArgument('storagePageId'),
            (bool)$input->getOption('verify-ssl')
        );

        $currentPage = 1;
        do {
            /** @var SpinOffDto[] $spinOffs */
            $spinOffs = $this->spinOffService->getSpinOffs($currentPage);
            if ($this->spinOffService->getMeta()->getTotal() === 0) {
                $output->writeln('No new spin offs found');
                return Command::SUCCESS;
            }

            foreach ($spinOffs as $spinOff) {
                $this->eventDispatcher->dispatch(
                    new ReceiveHioSpinOffEvent($spinOff, (int)$input->getArgument('storagePageId'))
                );
            }

            $currentPage++;
        } while ($currentPage <= $this->spinOffService->getMeta()->getLastPage());

        $output->writeln($this->spinOffService->getMeta()->getTotal() . ' SpinOffs imported successfully');
        return Command::SUCCESS;
    }
}
