<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\OrgUnit;

class ResearchInfrastructureDto
{
    protected string $description = '';
    protected int $id;
    protected string $language = '';
    protected string $title = '';
    protected string $type = '';
    protected string $visibility = '';

    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }
    public function setLanguage(string $language): void
    {
        $this->language = $language;
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

    static public function fromArray(array $data): self
    {
        if (count($data) === 0) {
            return new self();
        }
        $dto = new self();
        $dto->setDescription($data['description'] ?? '');
        $dto->setId($data['id']);
        $dto->setLanguage($data['language'] ?? '');
        $dto->setTitle($data['name'] ?? '');
        $dto->setType($data['type'] ?? '');
        $dto->setVisibility($data['visibility'] ?? '');

        return $dto;
    }
}
