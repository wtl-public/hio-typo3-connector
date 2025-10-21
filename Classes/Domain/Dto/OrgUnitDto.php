<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto;

use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\PostAddressDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\DoctoralProgramDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\EAddressDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\HabilitationDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\PatentDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\PersonDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\PrizeDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\ProjectDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\PublicationDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\ResearchInfrastructureDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\SpinOffDto;
use Wtl\HioTypo3Connector\Trait\WithDetails;
use Wtl\HioTypo3Connector\Trait\WithObjectId;
use Wtl\HioTypo3Connector\Trait\WithSearchIndex;
use Wtl\HioTypo3Connector\Trait\WithTitle;

class OrgUnitDto
{
    use WithObjectId;
    use WithDetails;
    use WithSearchIndex;
    use WithTitle;

    protected array $eAddresses = [];
    protected array $doctoralPrograms = [];
    protected array $habilitations = [];
    protected array $patents = [];
    protected array $persons = [];
    protected array $projects = [];
    protected array $prizes = [];
    protected array $publications = [];
    protected array $researchInfrastructures = [];
    protected array $spinOffs = [];

    public function getAddress(): ?PostAddressDto
    {
        return $this->address;
    }
    public function setAddress(?PostAddressDto $address): void
    {
        $this->address = $address;
    }

    public function getEAddresses(): array
    {
        return $this->eAddresses;
    }
    public function setEAddresses(array $eAddresses): void
    {
        $this->eAddresses = $eAddresses;
    }

    public function getPublications(): array
    {
        return $this->publications;
    }

    public function setPublications(array $publications): void
    {
        $this->publications = $publications;
    }

    public function getPersons(): array
    {
        return $this->persons;
    }
    public function setPersons(array $persons): void
    {
        $this->persons = $persons;
    }

    public function getProjects(): array
    {
        return $this->projects;
    }
    public function setProjects(array $projects): void
    {
        $this->projects = $projects;
    }

    public function getPrizes(): array
    {
        return $this->prizes;
    }
    public function setPrizes(array $prizes): void
    {
        $this->prizes = $prizes;
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
        $dto->setDetails($data);
        $dto->setObjectId($data['id']);
        $dto->setSearchIndex($data);
        $dto->setTitle($data['name'] ?? '');

        $dto->setDoctoralPrograms(array_map(fn($item) => DoctoralProgramDto::fromArray($item), $data['doctoralPrograms'] ?? []));
        $dto->setEAddresses(array_map(fn($item) => EAddressDto::fromArray($item), $data['eAddresses'] ?? []));
        $dto->setHabilitations(array_map(fn($item) => HabilitationDto::fromArray($item), $data['habilitations'] ?? []));
        $dto->setPatents(array_map(fn($item) => PatentDto::fromArray($item), $data['patents'] ?? []));
        $dto->setPersons(array_map(fn($item) => PersonDto::fromArray($item), $data['persons'] ?? []));
        $dto->setPrizes(array_map(fn($item) => PrizeDto::fromArray($item), $data['prizes'] ?? []));
        $dto->setProjects(array_map(fn($item) => ProjectDto::fromArray($item), $data['projects'] ?? []));
        $dto->setPublications(array_map(fn($item) => PublicationDto::fromArray($item), $data['publications'] ?? []));
        $dto->setResearchInfrastructures(array_map(fn($item) => ResearchInfrastructureDto::fromArray($item), $data['researchInfrastructures'] ?? []));
        $dto->setSpinOffs(array_map(fn($item) => SpinOffDto::fromArray($item), $data['spinOffs'] ?? []));

        return $dto;
    }
}
