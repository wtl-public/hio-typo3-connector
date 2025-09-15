<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto;

use Wtl\HioTypo3Connector\Domain\Dto\SpinOff\OrgUnitDto;
use Wtl\HioTypo3Connector\Trait\WithDetails;
use Wtl\HioTypo3Connector\Trait\WithEndDate;
use Wtl\HioTypo3Connector\Trait\WithLanguage;
use Wtl\HioTypo3Connector\Trait\WithObjectId;
use Wtl\HioTypo3Connector\Trait\WithSearchIndex;
use Wtl\HioTypo3Connector\Trait\WithStartDate;

class SpinOffDto
{
    use WithObjectId;
    use WithDetails;
    use WithSearchIndex;

    use WithEndDate;
    use WithLanguage;
    use WithStartDate;

    protected string $description = '';
    protected string $name;
    // @var OrgUnitDto[]
    protected array $orgUnits = [];
    protected array $researchAreas = [];
    protected array $subjectAreas = [];

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getOrgUnits(): array
    {
        return $this->orgUnits;
    }

    public function setOrgUnits(array $orgUnits): void
    {
        $this->orgUnits = $orgUnits;
    }

    public function getResearchAreas(): array
    {
        return $this->researchAreas;
    }

    public function setResearchAreas(array $researchAreas): void
    {
        $this->researchAreas = $researchAreas;
    }

    public function getSubjectAreas(): array
    {
        return $this->subjectAreas;
    }

    public function setSubjectAreas(array $subjectAreas): void
    {
        $this->subjectAreas = $subjectAreas;
    }

    static public function fromArray(array $data): SpinOffDto
    {
        $dto = new self();
        $dto->setDetails($data);
        $dto->setSearchIndex($data);
        $dto->setObjectId($data['id']);

        $dto->setDescription($data['description'] ?? '');
        $dto->setEndDate(isset($data['endDate']) ? new \DateTime($data['endDate']) : null);
        $dto->setLanguage($data['language'] ?? '');
        $dto->setName($data['name'] ?? '');
        $dto->setStartDate(isset($data['startDate']) ? new \DateTime($data['startDate']) : null);

        $orgUnits = [];
        foreach ($data['orgUnits'] ?? [] as $orgUnit) {
            $orgUnits[] = OrgUnitDto::fromArray($orgUnit);
        }
        $dto->setOrgUnits($orgUnits);

        return $dto;
    }
}
