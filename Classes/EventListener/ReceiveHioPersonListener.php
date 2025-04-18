<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Wtl\HioTypo3Connector\Domain\Repository\PersonRepository;
use Wtl\HioTypo3Connector\Event\ReceiveHioPersonEvent;

class ReceiveHioPersonListener
{
    protected ?PersonRepository $personRepository = null;

    public function injectPersonRepository(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }
    public function __invoke(ReceiveHioPersonEvent $event): void
    {
        $this->personRepository->save($event->getHioPerson(), $event->getStoragePid());
    }
}
