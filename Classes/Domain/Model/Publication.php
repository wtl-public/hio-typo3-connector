<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Publication extends AbstractEntity
{
    protected int $objectId = 0;

    protected string $title = '';

    protected string $type = '';

    protected ?string $releaseYear = null;

    /**
     * @var string
     */
    protected mixed $details;

    public function getObjectId(): int
    {
        return $this->objectId;
    }
    public function setObjectId($objectId): void
    {
        $this->objectId = $objectId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getDetails(): mixed
    {
        return json_decode($this->details, true);
    }
    public function setDetails($details): void
    {
        $this->details = json_encode($details);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType($type): void
    {
        $this->type = $type;
    }

    public function getReleaseYear(): ?string
    {
        return $this->releaseYear;
    }

    public function setReleaseYear(?string $releaseYear): void
    {
        $this->releaseYear = $releaseYear;
    }
}
