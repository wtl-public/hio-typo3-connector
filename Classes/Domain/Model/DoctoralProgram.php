<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Wtl\HioTypo3Connector\Domain\Model\Trait\HasPersonsTrait;
use Wtl\HioTypo3Connector\Domain\Model\Trait\HasSlugFieldTrait;

class DoctoralProgram extends AbstractEntity
{
    use HasPersonsTrait;
    use HasSlugFieldTrait;
    
    protected int $objectId = 0;

    protected string $title = '';

    /**
     * @var string
     */
    protected mixed $details;

    /**
     * @var string
     */
    protected mixed $searchIndex;

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->persons = new ObjectStorage();
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


    public function getSearchIndex()
    {
        return $this->searchIndex;
    }

    public function setSearchIndex(string $searchIndex)
    {
        $this->searchIndex = $searchIndex;
    }
}
