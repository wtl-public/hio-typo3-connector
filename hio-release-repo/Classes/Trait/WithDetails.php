<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

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
