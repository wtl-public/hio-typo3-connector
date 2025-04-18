<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Wtl\HioTypo3Connector\Domain\Repository\PersonRepository;
use Wtl\HioTypo3Connector\Domain\Repository\PublicationRepository;
use Wtl\HioTypo3Connector\Event\ReceiveHioPersonEvent;
use Wtl\HioTypo3Connector\Event\ReceiveHioPublicationEvent;
use Wtl\HioTypo3Connector\Services\HioPersonService;

class ReceiveHioPublicationListener
{
    protected ?PublicationRepository $publicationRepository = null;

    public function injectPublicationRepository(PublicationRepository $publicationRepository)
    {
        $this->publicationRepository = $publicationRepository;
    }
    public function __invoke(ReceiveHioPublicationEvent $event): void
    {
        $this->publicationRepository->savePublication($event->getHioPublication(), $event->getStoragePid());
    }
}
