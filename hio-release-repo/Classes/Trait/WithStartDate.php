<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

trait WithStartDate
{
    protected ?\DateTime $startDate = null;

    public function getStartDate(): \DateTime|null
    {
        return $this->startDate;
    }
    public function setStartDate(?\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }
}
