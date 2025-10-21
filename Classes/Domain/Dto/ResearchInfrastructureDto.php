<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\VisibilityDto;
use Wtl\HioTypo3Connector\Domain\Dto\ResearchInfrastructure\OrgUnitDto;
use Wtl\HioTypo3Connector\Domain\Dto\ResearchInfrastructure\PublicationDto;
use Wtl\HioTypo3Connector\Trait\WithDescription;
use Wtl\HioTypo3Connector\Trait\WithDetails;
use Wtl\HioTypo3Connector\Trait\WithDynamicObjects;
use Wtl\HioTypo3Connector\Trait\WithLanguage;
use Wtl\HioTypo3Connector\Trait\WithObjectId;
use Wtl\HioTypo3Connector\Trait\WithSearchIndex;
use Wtl\HioTypo3Connector\Trait\WithTitle;
use Wtl\HioTypo3Connector\Trait\WithType;
use Wtl\HioTypo3Connector\Trait\WithVisibility;

class ResearchInfrastructureDto
{
    use WithDetails;
    use WithDescription;
    use WithDynamicObjects;
    use WithLanguage;
    use WithObjectId;
    use WithSearchIndex;
    use WithTitle;
    use WithType;
    use WithVisibility;

    protected string $kind = '';
    protected array $orgUnits = [];
    protected array $publications = [];

    public function getKind(): string
    {
        return $this->kind;
    }

    public function setKind(string $kind): void
    {
        $this->kind = $kind;
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
        $dto->setVisibility(VisibilityDto::fromArray($data['visibility']) ?? '');

        return $dto;
    }
}
