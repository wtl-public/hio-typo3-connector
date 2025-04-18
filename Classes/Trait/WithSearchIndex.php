<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

trait WithSearchIndex
{
    protected array $searchIndex = [];

    public function getSearchIndex(): string
    {
        return strtolower(json_encode($this->searchIndex));
    }

    public function setSearchIndex($searchIndex): void
    {
        $this->searchIndex = $searchIndex;
    }
}
