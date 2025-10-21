<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

trait WithId
{
    protected ?int $id;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(?int $id): void
    {
        $this->id = $id;
    }
}
