<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Wtl\HioTypo3Connector\Domain\Repository\ProjectRepository;
use Wtl\HioTypo3Connector\Event\ReceiveHioProjectEvent;

class ReceiveHioProjectListener
{
    protected ?ProjectRepository $projectRepository = null;

    public function injectProjectRepository(ProjectRepository $projectRepository): void
    {
        $this->projectRepository = $projectRepository;
    }
    public function __invoke(ReceiveHioProjectEvent $event): void
    {
        $this->projectRepository->save($event->getHioProject(), $event->getStoragePid());
    }
}
