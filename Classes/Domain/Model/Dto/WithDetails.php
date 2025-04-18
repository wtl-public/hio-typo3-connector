<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model\Dto;

trait WithDetails
{
    protected array $details = [];

    public function getDetails(): array
    {
        return $this->details;
    }

    public function setDetails(array $details): void
    {
        $this->details = $details;
    }
}
