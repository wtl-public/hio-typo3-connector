<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

use Wtl\HioTypo3Connector\Domain\Dto\Misc\StatusDto;

trait WithStatus
{
    protected ?StatusDto $status;

    public function getStatus(): ?StatusDto
    {
        return $this->status;
    }

    public function setStatus(?StatusDto $status): void
    {
        $this->status = $status;
    }
}
