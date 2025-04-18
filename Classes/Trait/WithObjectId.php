<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

trait WithObjectId
{
    protected int $objectId = 0;

    public function getObjectId(): int
    {
        return $this->objectId;
    }

    public function setObjectId(int $objectId): void
    {
        $this->objectId = $objectId;
    }
}
