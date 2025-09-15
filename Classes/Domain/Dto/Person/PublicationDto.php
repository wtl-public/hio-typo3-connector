<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Person;

class PublicationDto
{
    protected string $document = '';
    protected ?int $id = null;
    protected string $resource = '';
    protected ?bool $reviewed = null;
    protected string $status = '';
    protected string $subtitle = '';
    protected string $title = '';
    protected string $type = '';
    protected string $visibility = '';

    public function getDocument(): string
    {
        return $this->document;
    }

    public function setDocument(string $document): void
    {
        $this->document = $document;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getResource(): string
    {
        return $this->resource;
    }

    public function setResource(string $resource): void
    {
        $this->resource = $resource;
    }

    public function getReviewed(): ?bool
    {
        return $this->reviewed;
    }

    public function setReviewed(?bool $reviewed): void
    {
        $this->reviewed = $reviewed;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): void
    {
        $this->subtitle = $subtitle;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getVisibility(): string
    {
        return $this->visibility;
    }

    public function setVisibility(string $visibility): void
    {
        $this->visibility = $visibility;
    }

    public static function fromArray(array $data): self
    {
        $dto = new self();
        $dto->setDocument($data['document'] ?? '');
        $dto->setId($data['id'] ?? null);
        $dto->setResource($data['resource'] ?? '');
        $dto->setReviewed($data['reviewed'] ?? null);
        $dto->setStatus($data['status'] ?? '');
        $dto->setSubtitle($data['subtitle'] ?? '');
        $dto->setTitle($data['title'] ?? '');
        $dto->setType($data['type'] ?? '');
        $dto->setVisibility($data['visibility'] ?? '');

        return $dto;
    }
}
