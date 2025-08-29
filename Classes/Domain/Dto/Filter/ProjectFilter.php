<?php

namespace Wtl\HioTypo3Connector\Domain\Dto\Filter;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Extbase\Mvc\Request as ExtbaseRequest;
use Wtl\HioTypo3Connector\Domain\Dto\Filter\FilterDto as BaseFilter;

class ProjectFilter extends FilterDto
{
    public function __construct(
        protected bool $showFilterForm = true,
        protected bool $reset = false,
        protected ?string $searchTerm = null,
        protected ?string $endDateFrom = null,
        protected ?string $endDateTo = null,
        protected ?string $startDateFrom = null,
        protected ?string $startDateTo = null,
        protected ?string $status = null,
        protected ?string $type = null,
    )
    {
        parent::__construct(
            $showFilterForm,
            $searchTerm,
            $reset
        );
    }

    public function withStartDateFrom(?string $startDateFrom): self
    {
        $this->startDateFrom = $startDateFrom;
        return $this;
    }
    public function getStartDateFrom(): ?string
    {
        return $this->startDateFrom;
    }
    public function withStartDateTo(?string $startDateTo): self
    {
        $this->startDateTo = $startDateTo;
        return $this;
    }
    public function getStartDateTo(): ?string
    {
        return $this->startDateTo;
    }

    public function withEndDateFrom(?string $endDateFrom): self
    {
        $this->endDateFrom = $endDateFrom;
        return $this;
    }
    public function getEndDateFrom(): ?string
    {
        return $this->endDateFrom;
    }
    public function withEndDateTo(?string $endDateTo): self
    {
        $this->endDateTo = $endDateTo;
        return $this;
    }
    public function getEndDateTo(): ?string
    {
        return $this->endDateTo;
    }

    public function withType(?string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function withStatus(?string $status): self
    {
        $this->status = $status;
        return $this;
    }
    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                'startDateFrom' => $this->getStartDateFrom(),
                'startDateTo' => $this->getStartDateTo(),
                'endDateFrom' => $this->getEndDateFrom(),
                'endDateTo' => $this->getEndDateTo(),
                'status' => $this->getStatus(),
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
        if (isset($filter['startDateFrom'])) {
            $instance->startDateFrom = (string)$filter['startDateFrom'];
        }
        if (isset($filter['startDateTo'])) {
            $instance->startDateTo = (string)$filter['startDateTo'];
        }
        if (isset($filter['endDateFrom'])) {
            $instance->endDateFrom = (string)$filter['endDateFrom'];
        }
        if (isset($filter['endDateTo'])) {
            $instance->endDateTo = (string)$filter['endDateTo'];
        }
        if (isset($filter['status'])) {
            $instance->status = (string)$filter['status'];
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
