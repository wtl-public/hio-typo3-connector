<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Wtl\HioTypo3Connector\Domain\Repository\HabilitationRepository;
use Wtl\HioTypo3Connector\Event\ReceiveHioHabilitationEvent;

class ReceiveHioHabilitationListener
{
    protected ?HabilitationRepository $habilitationRepository = null;

    public function injectHabilitationRepository(HabilitationRepository $habilitationRepository): void
    {
        $this->habilitationRepository = $habilitationRepository;
    }
    public function __invoke(ReceiveHioHabilitationEvent $event): void
    {
        $this->habilitationRepository->save($event->getHioHabilitation(), $event->getStoragePid());
    }
}
