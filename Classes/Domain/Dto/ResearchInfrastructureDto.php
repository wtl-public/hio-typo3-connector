<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Wtl\HioTypo3Connector\Domain\Dto\ResearchInfrastructure\OrgUnitDto;
use Wtl\HioTypo3Connector\Domain\Dto\ResearchInfrastructure\PublicationDto;
use Wtl\HioTypo3Connector\Trait\WithDetails;
use Wtl\HioTypo3Connector\Trait\WithObjectId;
use Wtl\HioTypo3Connector\Trait\WithSearchIndex;

class ResearchInfrastructureDto
{
    use WithObjectId;
    use WithDetails;
    use WithSearchIndex;

    protected string $description = '';
    protected array $dynamicObjects = [];
    protected string $kind = '';
    protected string $language = '';
    protected array $orgUnits = [];
    protected array $publications = [];

    protected string $title = '';
    protected string $type = '';
    protected string $visibility = '';

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDynamicObjects(): array
    {
        return $this->dynamicObjects;
    }

    public function setDynamicObjects(array $dynamicObjects): void
    {
        $this->dynamicObjects = $dynamicObjects;
    }

    public function getKind(): string
    {
        return $this->kind;
    }

    public function setKind(string $kind): void
    {
        $this->kind = $kind;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    public function getOrgUnits(): array
    {
        return $this->orgUnits;
    }
    public function setOrgUnits(array $orgUnits): void
    {
        $this->orgUnits = $orgUnits;
    }

    public function getPublications(): array
    {
        return $this->publications;
    }

    public function setPublications(array $publications): void
    {
        $this->publications = $publications;
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

    static public function fromArray(array $data): ResearchInfrastructureDto
    {
        $dto = new self();
        $dto->setObjectId($data['id']);
        $dto->setDetails($data);
        $dto->setSearchIndex($data);

        $dto->setDescription($data['description'] ?? '');
        $dto->setDynamicObjects($data['dynamicObjects'] ?? []);
        $dto->setKind($data['kind'] ?? '');
        $dto->setLanguage($data['language'] ?? '');
        $dto->setOrgUnits(array_map(fn($item) => OrgUnitDto::fromArray($item), $data['orgUnits'] ?? []));
        $dto->setPublications(array_map(fn($item) => PublicationDto::fromArray($item), $data['publications'] ?? []));
        $dto->setTitle($data['title'] ?? '');
        $dto->setType($data['type'] ?? '');
        $dto->setVisibility($data['visibility'] ?? '');

        return $dto;
    }
}
