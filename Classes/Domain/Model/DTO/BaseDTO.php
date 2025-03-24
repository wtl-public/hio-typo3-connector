<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model\DTO;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

abstract class BaseDTO
{
    protected int $extbaseUid = 0;
    protected int $objectId = 0;
    protected array $details = [];
    protected array $searchIndex = [];

    public function getExtbaseUid(): int
    {
        return $this->extbaseUid;
    }
    public function setExtbaseUid(int $extbaseUid): void
    {
        $this->extbaseUid = $extbaseUid;
    }

    public function getObjectId(): int
    {
        return $this->objectId;
    }
    public function setObjectId($objectId): void
    {
        $this->objectId = $objectId;
    }

    public function getDetails(): array
    {
        return $this->details;
    }
    public function setDetails(array $details): void
    {
        $this->details = $details;
    }

    abstract static public function fromDomainModel(AbstractEntity $model): static;

    public function getSearchIndex()
    {
        return strtolower(json_encode($this->searchIndex));
    }

    public function setSearchIndex($searchIndex)
    {
        $this->searchIndex = $searchIndex;

        return $this;
    }
}
