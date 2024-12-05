<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Project extends AbstractEntity
{
    protected int $objectId = 0;

    protected string $title = '';

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
}
