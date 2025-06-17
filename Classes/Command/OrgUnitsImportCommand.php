<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Command;

use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnitDto;
use Wtl\HioTypo3Connector\Event\ReceiveHioOrgUnitEvent;
use Wtl\HioTypo3Connector\Event\ReceiveHioPatentEvent;
use Wtl\HioTypo3Connector\Services\HioOrgUnitService;
use Wtl\HioTypo3Connector\Services\HioPatentService;
use Wtl\HioTypo3Connector\Trait\WithConfigureImportCommandTrait;

class OrgUnitsImportCommand extends Command
{
    use WithConfigureImportCommandTrait;

    protected static $defaultName = 'hio:orgunits:import';

    public function __construct(
        private readonly HioOrgUnitService $orgUnitService,
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
        $this->orgUnitService->configure(
            $input->getArgument('endpoint'),
            $input->getArgument('username'),
            $input->getArgument('password'),
            $input->getArgument('storagePageId'),
            (bool)$input->getOption('verify-ssl')
        );

        $currentPage = 1;
        do {
            /** @var OrgUnitDto[] $orgUnits */
            $orgUnits = $this->orgUnitService->getPatents($currentPage);
            if ($this->orgUnitService->getMeta()->getTotal() === 0) {
                $output->writeln('No new organisation units found');
                return Command::SUCCESS;
            }

            foreach ($orgUnits as $orgUnit) {
                $this->eventDispatcher->dispatch(
                    new ReceiveHioOrgUnitEvent($orgUnit, (int)$input->getArgument('storagePageId'))
                );
            }

            $currentPage++;
        } while ($currentPage <= $this->orgUnitService->getMeta()->getLastPage());

        $output->writeln($this->orgUnitService->getMeta()->getTotal() . ' Organisation units imported successfully');
        return Command::SUCCESS;
    }
}
