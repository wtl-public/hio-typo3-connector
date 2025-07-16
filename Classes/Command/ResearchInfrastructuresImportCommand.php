<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Command;

use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Dto\ResearchInfrastructureDto;
use Wtl\HioTypo3Connector\Event\ReceiveHioResearchInfrastructureEvent;
use Wtl\HioTypo3Connector\Services\HioResearchInfrastructureService;
use Wtl\HioTypo3Connector\Trait\WithConfigureImportCommandTrait;

class ResearchInfrastructuresImportCommand extends Command
{
    use WithConfigureImportCommandTrait;

    protected static $defaultName = 'hio:researchinfrastructures:import';

    public function __construct(
        private readonly HioResearchInfrastructureService $service,
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
        $this->service->configure(
            $input->getArgument('endpoint'),
            $input->getArgument('username'),
            $input->getArgument('password'),
            $input->getArgument('storagePageId'),
            (bool)$input->getOption('verify-ssl')
        );

        $currentPage = 1;
        do {
            /** @var ResearchInfrastructureDto[] $researchInfrastructureDtos */
            $researchInfrastructureDtos = $this->service->getResearchInfrastructures($currentPage);
            if ($this->service->getMeta()->getTotal() === 0) {
                $output->writeln('No new research infrastructures found');
                return Command::SUCCESS;
            }

            foreach ($researchInfrastructureDtos as $researchInfrastructureDto) {
                $this->eventDispatcher->dispatch(
                    new ReceiveHioResearchInfrastructureEvent($researchInfrastructureDto, (int)$input->getArgument('storagePageId'))
                );
            }

            $currentPage++;
        } while ($currentPage <= $this->service->getMeta()->getLastPage());

        $output->writeln($this->service->getMeta()->getTotal() . ' research infrastructures imported successfully');
        return Command::SUCCESS;
    }
}
