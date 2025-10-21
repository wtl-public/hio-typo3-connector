<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

trait WithValidFrom
{
    protected ?\DateTime $validFrom = null;

    public function getValidFrom(): \DateTime|null
    {
        return $this->validFrom;
    }
    public function setValidFrom(?\DateTime $validFrom): void
    {
        $this->validFrom = $validFrom;
    }
}
