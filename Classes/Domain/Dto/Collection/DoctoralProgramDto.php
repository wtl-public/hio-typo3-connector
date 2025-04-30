<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Collection;

class DoctoralProgramDto
{
    protected ?string $courseOfStudy = '';
    protected ?string $description = '';
    protected ?\DateTime $endDate = null;
    protected int $id;
    protected string $language = '';
    protected ?\DateTime $startDate = null;
    protected string $title = '';

    public function getCourseOfStudy(): ?string
    {
        return $this->courseOfStudy;
    }

    public function setCourseOfStudy(?string $courseOfStudy): void
    {
        $this->courseOfStudy = $courseOfStudy;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

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

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    static public function fromArray(array $data): self
    {
        $dto = new self();
        $dto->setCourseOfStudy($data['courseOfStudy'] ?? '');
        $dto->setDescription($data['description'] ?? '');
        $dto->setEndDate(isset($data['endDate']) ? new \DateTime($data['endDate']) : null);
        $dto->setId($data['id']);
        $dto->setLanguage($data['language'] ?? '');
        $dto->setStartDate(isset($data['startDate']) ? new \DateTime($data['startDate']) : null);
        $dto->setTitle($data['title']);
        return $dto;
    }
}
