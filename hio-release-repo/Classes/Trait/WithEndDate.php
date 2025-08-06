<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

trait WithEndDate
{
    protected ?\DateTime $endDate = null;

    public function getEndDate(): \DateTime|null
    {
        return $this->endDate;
    }
    public function setEndDate(?\DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }
}
