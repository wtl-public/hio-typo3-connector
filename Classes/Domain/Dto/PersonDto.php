<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Wtl\HioTypo3Connector\Domain\Dto\Person\AddressDto;
use Wtl\HioTypo3Connector\Domain\Dto\Person\AttributeDto;
use Wtl\HioTypo3Connector\Domain\Dto\Person\DoctoralProgramDto;
use Wtl\HioTypo3Connector\Domain\Dto\Person\HabilitationDto;
use Wtl\HioTypo3Connector\Domain\Dto\Person\OrgUnitDto;
use Wtl\HioTypo3Connector\Domain\Dto\Person\PatentDto;
use Wtl\HioTypo3Connector\Domain\Dto\Person\ProjectDto;
use Wtl\HioTypo3Connector\Domain\Dto\Person\PublicationDto;
use Wtl\HioTypo3Connector\Trait\WithDetails;
use Wtl\HioTypo3Connector\Trait\WithObjectId;
use Wtl\HioTypo3Connector\Trait\WithSearchIndex;

class PersonDto
{
    use WithObjectId;
    use WithDetails;
    use WithSearchIndex;

    protected string $name = '';

    //  @var AddressDto[]
    protected array $addresses = [];
    // @var AttributeDto[]
    protected array $attributes = [];
    protected array $doctoralPrograms = [];
    protected array $habilitations = [];
    protected array $patents = [];
    protected array $projects = [];
    protected array $publications = [];
    protected array $orgUnits = [];

    public function getAddresses(): array
    {
        return $this->addresses;
    }

    public function setAddresses(array $addresses): void
    {
        $this->addresses = $addresses;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPublications(): array
    {
        return $this->publications;
    }

    public function setPublications(array $publications): void
    {
        $this->publications = $publications;
    }

    public function getProjects(): array
    {
        return $this->projects;
    }

    public function setProjects(array $projects): void
    {
        $this->projects = $projects;
    }

    public function getPatents(): array
    {
        return $this->patents;
    }

    public function setPatents(array $patents): void
    {
        $this->patents = $patents;
    }

    public function getDoctoralPrograms(): array
    {
        return $this->doctoralPrograms;
    }

    public function setDoctoralPrograms(array $doctoralPrograms): void
    {
        $this->doctoralPrograms = $doctoralPrograms;
    }

    public function getHabilitations(): array
    {
        return $this->habilitations;
    }

    public function setHabilitations(array $habilitations): void
    {
        $this->habilitations = $habilitations;
    }

    public function getOrgUnits(): array
    {
        return $this->orgUnits;
    }

    public function setOrgUnits(array $orgUnits): void
    {
        $this->orgUnits = $orgUnits;
    }

    static public function fromArray(array $data): PersonDto
    {
        $dto = new self();
        $dto->setObjectId($data['id']);
        $dto->setName($data['name']);
        $dto->setDetails($data);
        $dto->setSearchIndex($data);

        $dto->setAddresses(array_map(fn($item) => AddressDto::fromArray($item), $data['addresses'] ?? []));
        $dto->setAttributes(array_map(fn($item) => AttributeDto::fromArray($item), $data['attributes'] ?? []));
        $dto->setDoctoralPrograms(array_map(fn($item) => DoctoralProgramDto::fromArray($item), $data['doctoralPrograms'] ?? []));
        $dto->setHabilitations(array_map(fn($item) => HabilitationDto::fromArray($item), $data['habilitations'] ?? []));
        $dto->setOrgUnits(array_map(fn($item) => OrgUnitDto::fromArray($item), $data['orgUnits'] ?? []));
        $dto->setPatents(array_map(fn($item) => PatentDto::fromArray($item), $data['patents'] ?? []));
        $dto->setProjects(array_map(fn($item) => ProjectDto::fromArray($item), $data['projects'] ?? []));
        $dto->setPublications(array_map(fn($item) => PublicationDto::fromArray($item), $data['publications'] ?? []));

        return $dto;
    }
}
