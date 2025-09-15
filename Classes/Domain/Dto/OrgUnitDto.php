<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto;

use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\AddressDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\DoctoralProgramDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\HabilitationDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\PatentDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\ProjectDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\PublicationDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\ResearchInfrastructureDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\SpinOffDto;
use Wtl\HioTypo3Connector\Trait\WithDetails;
use Wtl\HioTypo3Connector\Trait\WithObjectId;
use Wtl\HioTypo3Connector\Trait\WithSearchIndex;

class OrgUnitDto
{
    use WithObjectId;
    use WithDetails;
    use WithSearchIndex;

    protected ?AddressDto $address = null;
    protected string $title = '';

    protected array $doctoralPrograms = [];
    protected array $habilitations = [];
    protected array $patents = [];
    protected array $projects = [];
    protected array $publications = [];
    protected array $researchInfrastructures = [];
    protected array $spinOffs = [];

    public function getAddress(): ?AddressDto
    {
        return $this->address;
    }
    public function setAddress(?AddressDto $address): void
    {
        $this->address = $address;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $title): void
    {
        $this->title = $title;
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

    public function getResearchInfrastructures(): array
    {
        return $this->researchInfrastructures;
    }
    public function setResearchInfrastructures(array $researchInfrastructures): void
    {
        $this->researchInfrastructures = $researchInfrastructures;
    }

    public function getSpinOffs(): array
    {
        return $this->spinOffs;
    }
    public function setSpinOffs(array $spinOffs): void
    {
        $this->spinOffs = $spinOffs;
    }

    static public function fromArray(array $data): OrgUnitDto
    {
        $dto = new self();
        $dto->setObjectId($data['id']);
        $dto->setDetails($data);
        $dto->setSearchIndex($data);

        $dto->setAddress(isset($data['address']) ? AddressDto::fromArray($data['address']) : null);
        $dto->setTitle($data['name'] ?? '');

        $dto->setDoctoralPrograms(array_map(fn($item) => DoctoralProgramDto::fromArray($item), $data['doctoralPrograms'] ?? []));
        $dto->setHabilitations(array_map(fn($item) => HabilitationDto::fromArray($item), $data['habilitations'] ?? []));
        $dto->setPatents(array_map(fn($item) => PatentDto::fromArray($item), $data['patents'] ?? []));
        $dto->setProjects(array_map(fn($item) => ProjectDto::fromArray($item), $data['projects'] ?? []));
        $dto->setPublications(array_map(fn($item) => PublicationDto::fromArray($item), $data['publications'] ?? []));
        $dto->setResearchInfrastructures(array_map(fn($item) => ResearchInfrastructureDto::fromArray($item), $data['researchInfrastructures'] ?? []));
        $dto->setSpinOffs(array_map(fn($item) => SpinOffDto::fromArray($item), $data['spinOffs'] ?? []));

        return $dto;
    }
}
