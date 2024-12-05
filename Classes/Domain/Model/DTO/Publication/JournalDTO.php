<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model\DTO\Publication;

class JournalDTO
{
    protected string $title = '';
    protected int $releaseYear = 0;
    protected ?string $volume = null;
    protected string $issue = '';
    protected string $pageRange = '';
    protected string $publisher = '';

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getReleaseYear(): int
    {
        return $this->releaseYear;
    }
    public function setReleaseYear(int $releaseYear): void
    {
        $this->releaseYear = $releaseYear;
    }

    public function getVolume(): ?string
    {
        return $this->volume;
    }
    public function setVolume(?string $volume): void
    {
        $this->volume = $volume;
    }

    public function getIssue(): string
    {
        return $this->issue;
    }
    public function setIssue(string $issue): void
    {
        $this->issue = $issue;
    }

    public function getPageRange(): string
    {
        return $this->pageRange;
    }
    public function setPageRange(string $pageRange): void
    {
        $this->pageRange = $pageRange;
    }

    public function getPublisher(): string
    {
        return $this->publisher;
    }
    public function setPublisher(string $publisher): void
    {
        $this->publisher = $publisher;
    }

    static public function fromArray(array $data): self
    {
        $journalData = new self();
        $journalData->setTitle($data['title'] ?? '');
        $journalData->setReleaseYear($data['releaseYear'] ?? 0);
        $journalData->setVolume($data['volume'] ?? null);
        $journalData->setIssue($data['issue'] ?? '');
        $journalData->setPageRange($data['pageRange'] ?? '');
        $journalData->setPublisher($data['publisher'] ?? '');

        return $journalData;
    }
}
