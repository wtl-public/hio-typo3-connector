<?php

namespace Wtl\HioTypo3Connector\Publisher;

class ApiResponse
{
    protected array $data = [];
    protected ApiMeta $meta;
    protected array $links;
    /** @var array<int, int|null> deletedAt timestamp per object id of trashed records */
    protected array $trashed = [];
    /** @var array<int, int|null> lastSeenAt timestamp per object id of live records */
    protected array $lastSeen = [];

    public function __construct(array|null $data, array|null $meta, array|null $links)
    {
        // Trashed records (filter[trashed]=with) only carry id and deletedAt, keep them out of the DTO mapping
        foreach ($data ?? [] as $row) {
            if (isset($row['deletedAt'])) {
                $this->trashed[(int)$row['id']] = $this->toTimestamp($row['deletedAt']);
                continue;
            }
            if (isset($row['id'])) {
                $this->lastSeen[(int)$row['id']] = $this->toTimestamp($row['lastSeenAt'] ?? null);
            }
            $this->data[] = $row;
        }

        [$current_page, $from, $last_page, $links, $path, $per_page, $to, $total] = array_values($meta);
        $this->meta = new ApiMeta(
            $current_page,
            $per_page,
            $last_page,
            $total,
            $from,
            $to,
            $path,
            $links
        );
        $this->links = $links??[];
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getMeta(): ApiMeta
    {
        return $this->meta;
    }

    /**
     * @return array<int, int|null>
     */
    public function getTrashed(): array
    {
        return $this->trashed;
    }

    /**
     * @return array<int, int|null>
     */
    public function getLastSeen(): array
    {
        return $this->lastSeen;
    }

    public function getLinks(): array
    {
        return $this->links;
    }

    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'meta' => $this->meta,
            'links' => $this->links,
        ];
    }

    private function toTimestamp(mixed $dateTime): ?int
    {
        $timestamp = is_string($dateTime) ? strtotime($dateTime) : false;

        return $timestamp !== false ? $timestamp : null;
    }
}
