<?php

namespace Wtl\HioTypo3Connector\Domain\Dto\Filter;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Extbase\Mvc\Request as ExtbaseRequest;
use Wtl\HioTypo3Connector\Domain\Dto\Filter\FilterDto as BaseFilter;

class PublicationFilter extends FilterDto
{
    public function __construct(
        protected bool $showFilterForm = true,
        protected bool $reset = false,
        protected ?string $searchTerm = null,
        protected ?string $releaseYearFrom = null,
        protected ?string $releaseYearTo = null,
        protected ?string $type = null,
    )
    {
        parent::__construct(
            $showFilterForm,
            $searchTerm,
            $reset
        );
    }

    public function withReleaseYearFrom(?string $releaseYear): self
    {
        $clone = clone $this;
        $clone->releaseYearFrom = $releaseYear;
        return $clone;
    }

    public function getReleaseYearFrom(): ?string
    {
        return $this->releaseYearFrom;
    }

    public function withReleaseYearTo(?string $releaseYear): self
    {
        $clone = clone $this;
        $clone->releaseYearTo = $releaseYear;
        return $clone;
    }

    public function getReleaseYearTo(): ?string
    {
        return $this->releaseYearTo;
    }

    public function withType(?string $type): self
    {
        $clone = clone $this;
        $clone->type = $type;
        return $clone;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                'releaseYearFrom' => $this->getReleaseYearFrom(),
                'releaseYearTo' => $this->getReleaseYearTo(),
                'type' => $this->getType(),
            ]
        );
    }

    public static function fromArray(array $filter, self|BaseFilter|null $origin = null): self
    {
        $instance = $origin instanceof self ? clone $origin : new self();
        if (isset($filter['showFilterForm'])) {
            $instance->showFilterForm = (bool)$filter['showFilterForm'];
        }
        if (isset($filter['searchTerm'])) {
            $instance->searchTerm = (string)$filter['searchTerm'];
        }
        if (isset($filter['reset'])) {
            $instance->reset = (bool)$filter['reset'];
        }
        if (isset($filter['releaseYearFrom'])) {
            $instance->releaseYearFrom = (string)$filter['releaseYearFrom'];
        }
        if (isset($filter['releaseYearTo'])) {
            $instance->releaseYearTo = (string)$filter['releaseYearTo'];
        }
        if (isset($filter['type'])) {
            $instance->type = (string)$filter['type'];
        }
        return $instance;
    }

    public static function fromRequest(ServerRequestInterface $request, self|BaseFilter|null $origin = null): self
    {
        $data = $request instanceof ExtbaseRequest
            ? $request->getArguments()
            : array_merge_recursive($request->getQueryParams(), (array)($request->getParsedBody() ?? []));

        if (isset($data['filter']) && is_array($data['filter'])) {
            $filter = $data['filter'];
            return self::fromArray($filter, $origin);
        }

        return new self();
    }
}
