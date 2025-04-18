<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Wtl\HioTypo3Connector\Domain\Repository\PatentRepository;
use Wtl\HioTypo3Connector\Event\ReceiveHioPatentEvent;

class ReceiveHioPatentListener
{
    protected ?PatentRepository $patentRepository = null;

    public function injectPatentRepository(PatentRepository $patentRepository): void
    {
        $this->patentRepository = $patentRepository;
    }
    public function __invoke(ReceiveHioPatentEvent $event): void
    {
        $this->patentRepository->save($event->getHioPatent(), $event->getStoragePid());
    }
}
