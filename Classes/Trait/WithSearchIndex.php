<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

trait WithSearchIndex
{
    protected array $searchIndex = [];

    public function getSearchIndex(): string
    {
        return mb_strtolower(json_encode($this->searchIndex, JSON_UNESCAPED_UNICODE));
    }

    public function setSearchIndex($searchIndex): void
    {
        $this->searchIndex = $searchIndex;
    }
}
