<?php

namespace Wtl\HioTypo3Connector\Publisher;

class ApiMeta
{
    protected int $currentPage;
    protected int $perPage;
    protected int $lastPage;
    protected int $total;
    protected int $from;
    protected int $to;
    protected string $path;
    protected array $links;

    public function __construct(int $currentPage = 0, int $perPage = 0, int $lastPage = 0, int $total = 0, int $from = 0, int $to = 0, string $path = '', array $links = [])
    {
        $this->currentPage = $currentPage;
        $this->perPage = $perPage;
        $this->lastPage = $lastPage;
        $this->total = $total;
        $this->from = $from;
        $this->to = $to;
        $this->path = $path;
        $this->links = $links;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getFrom(): int
    {
        return $this->from;
    }

    public function getTo(): int
    {
        return $this->to;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function toArray(): array
    {
        return [
            'current_page' => $this->currentPage,
            'per_page' => $this->perPage,
            'last_page' => $this->lastPage,
            'total' => $this->total,
            'from' => $this->from,
            'to' => $this->to,
            'path' => $this->path,
            'links' => $this->links,
        ];
    }
}
