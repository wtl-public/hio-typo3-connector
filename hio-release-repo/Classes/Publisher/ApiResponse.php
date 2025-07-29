<?php

namespace Wtl\HioTypo3Connector\Publisher;

class ApiResponse
{
    protected array $data;
    protected ApiMeta $meta;
    protected array $links;

    public function __construct(array|null $data, array|null $meta, array|null $links)
    {
        $this->data = $data??[];

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
}
