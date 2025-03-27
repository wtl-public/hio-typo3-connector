<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

use Wtl\HioTypo3Connector\Command\ConfigurableTrait;
use Wtl\HioTypo3Connector\Domain\Repository\DoctorateRepository;
use Wtl\HioTypo3Connector\Services\HioDoctorateService;

class DoctoratesImportCommand extends Command
{
    use ConfigurableTrait;

    protected static $defaultName = 'hio:doctorates:import';

    public function __construct(
        private readonly DoctorateRepository $doctorateRepository,
        private readonly HioDoctorateService $hioDoctorateService,
        protected readonly PersistenceManager $persistenceManager)
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
        $this->hioDoctorateService->configure(
            $input->getArgument('endpoint'),
            $input->getArgument('username'),
            $input->getArgument('password'),
            $input->getArgument('storagePageId'),
            (bool)$input->getOption('verify-ssl')
        );

        $querySettings = $this->doctorateRepository->createQuery()->getQuerySettings()->setStoragePageIds([$input->getArgument('storagePageId')]);
        $this->doctorateRepository->setDefaultQuerySettings($querySettings);

        $currentPage = 1;
        do {
            $doctorates = $this->hioDoctorateService->getDoctorates($currentPage);
            if ($this->hioDoctorateService->getMeta()->getTotal() === 0) {
                $output->writeln('No new patents found');
                return Command::SUCCESS;
            }

            $this->doctorateRepository->saveDoctorates($doctorates, $input->getArgument('storagePageId'));

            $currentPage++;
        } while ($currentPage <= $this->hioDoctorateService->getMeta()->getLastPage());

        $output->writeln($this->hioDoctorateService->getMeta()->getTotal() . ' Doctorates imported successfully');
        return Command::SUCCESS;
    }
}
