<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

trait WithValidTo
{
    protected ?\DateTime $validTo = null;

    public function getValidTo(): \DateTime|null
    {
        return $this->validTo;
    }
    public function setValidTo(?\DateTime $validTo): void
    {
        $this->validTo = $validTo;
    }
}
