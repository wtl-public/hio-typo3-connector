<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Scheduler\Domain\Repository\SchedulerTaskRepository;
use Wtl\HioTypo3Connector\Scheduler\ImportResultTaskRepository;
use Wtl\HioTypo3Connector\Scheduler\ReadonlyImportResultTaskRepository;

return static function (ContainerConfigurator $configurator, ContainerBuilder $container): void {
    // TYPO3 14 made the internal scheduler repository readonly.
    $repositoryClass = match ((new Typo3Version())->getMajorVersion()) {
        12, 13 => ImportResultTaskRepository::class,
        14 => ReadonlyImportResultTaskRepository::class,
        default => null,
    };
    if ($repositoryClass === null || !class_exists(SchedulerTaskRepository::class)) {
        return;
    }

    $container->register($repositoryClass)
        ->setAutowired(true)
        ->setDecoratedService(SchedulerTaskRepository::class, null, 0, ContainerInterface::IGNORE_ON_INVALID_REFERENCE);
};
