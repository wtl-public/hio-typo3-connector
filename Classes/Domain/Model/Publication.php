<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

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

     /**
     * @var string
     */
    protected mixed $searchIndex;

    /**
     * @var ObjectStorage<CitationStyle>
     */
    protected ObjectStorage $citationStyles;

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->citationStyles = new ObjectStorage();
    }

    public function getCitationStyles(): ObjectStorage
    {
        return $this->citationStyles;
    }
    public function setCitationStyles(ObjectStorage $citationStyles): void
    {
        $this->citationStyles = $citationStyles;
    }
    public function addCitationStyle(CitationStyle $citationStyle): self
    {
        if (!$this->citationStyles->contains($citationStyle)) {
            $this->citationStyles->attach($citationStyle);
        }
        return $this;
    }
    public function removeCitationStyle(CitationStyle $citationStyle): self
    {
        if ($this->citationStyles->contains($citationStyle)) {
            $this->citationStyles->detach($citationStyle);
        }
        return $this;
    }

    public function getUid(): int
    {
        return $this->uid;
    }
    public function setUid($uid): void
    {
        $this->uid = $uid;
    }

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

    /**
     * Get the value of searchIndex
     *
     * @return  string
     */
    public function getSearchIndex()
    {
        return $this->searchIndex;
    }

    /**
     * Set the value of searchIndex
     *
     * @param  string  $searchIndex
     *
     * @return  self
     */
    public function setSearchIndex(string $searchIndex)
    {
        $this->searchIndex = $searchIndex;

        return $this;
    }
}
