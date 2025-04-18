<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto;

trait WithSearchIndex
{
    protected $searchIndex = [];

    public function getSearchIndex(): string
    {
        return strtolower(json_encode($this->searchIndex));
    }

    public function setSearchIndex($searchIndex): void
    {
        $this->searchIndex = $searchIndex;
    }
}
