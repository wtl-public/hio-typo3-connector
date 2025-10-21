<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

trait WithDynamicObjects
{
    protected array $dynamicObjects = [];

    public function getDynamicObjects(): array
    {
        return $this->dynamicObjects;
    }

    public function setDynamicObjects(array $dynamicObjects): void
    {
        $this->dynamicObjects = $dynamicObjects;
    }
}
