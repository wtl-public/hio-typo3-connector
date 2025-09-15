<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Person;

class ProjectDto
{
    protected ?\DateTime $endDate = null;
    protected int $id;
    protected string $language = '';
    protected string $objective = '';
    protected ?\DateTime $startDate = null;
    protected string $status = '';
    protected string $title = '';
    protected ?string $type = null;
    protected string $visibility = '';

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    public function getObjective(): string
    {
        return $this->objective;
    }

    public function setObjective(string $objective): void
    {
        $this->objective = $objective;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
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
        $dto = new self();
        $dto->setEndDate(isset($data['endDate']) ? new \DateTime($data['endDate']) : null);
        $dto->setId($data['id']);
        $dto->setLanguage($data['language'] ?? '');
        $dto->setObjective($data['objective'] ?? '');
        $dto->setStartDate(isset($data['startDate']) ? new \DateTime($data['startDate']) : null);
        $dto->setStatus($data['status'] ?? '');
        $dto->setTitle($data['title']);
        $dto->setType($data['type'] ?? null);
        $dto->setVisibility($data['visibility'] ?? '');
        return $dto;
    }
}
