<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto;

use Wtl\HioTypo3Connector\Domain\Dto\Misc\LanguageDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\ResearchAreaDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\ResearchAreaKdsfDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\SubjectAreaDto;
use Wtl\HioTypo3Connector\Domain\Dto\SpinOff\OrgUnitDto;
use Wtl\HioTypo3Connector\Trait\WithDescription;
use Wtl\HioTypo3Connector\Trait\WithDetails;
use Wtl\HioTypo3Connector\Trait\WithEndDate;
use Wtl\HioTypo3Connector\Trait\WithLanguage;
use Wtl\HioTypo3Connector\Trait\WithName;
use Wtl\HioTypo3Connector\Trait\WithObjectId;
use Wtl\HioTypo3Connector\Trait\WithSearchIndex;
use Wtl\HioTypo3Connector\Trait\WithStartDate;

class SpinOffDto
{
    use WithDescription;
    use WithDetails;
    use WithEndDate;
    use WithLanguage;
    use WithName;
    use WithObjectId;
    use WithSearchIndex;
    use WithStartDate;

    // @var OrgUnitDto[]
    protected array $orgUnits = [];
    /**
     * @var ResearchAreaDto[]
     */
    protected array $researchAreas = [];
    /**
     * @var ResearchAreaKdsfDto[]
     */
    protected array $researchAreasKdsf = [];
    /**
     * @var SubjectAreaDto
     */
    protected array $subjectAreas = [];

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

    public function getResearchAreasKdsf(): array
    {
        return $this->researchAreasKdsf;
    }
    public function setResearchAreasKdsf(array $researchAreasKdsf): void
    {
        $this->researchAreasKdsf = $researchAreasKdsf;
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
        $dto->setLanguage(LanguageDto::fromArray($data['language']) ?? null);
        $dto->setName($data['name'] ?? '');

        $dto->setOrgUnits(array_map(fn($item) => OrgUnitDto::fromArray($item), $data['orgUnits'] ?? []));
        $dto->setResearchAreas(array_map(fn($item) => ResearchAreaDto::fromArray($item), $data['researchAreas'] ?? []));
        $dto->setResearchAreasKdsf(array_map(fn($item) => ResearchAreaKdsfDto::fromArray($item), $data['researchAreasKdfs'] ?? []));
        $dto->setSubjectAreas(array_map(fn($item) => SubjectAreaDto::fromArray($item), $data['subjectAreas'] ?? []));

        $dto->setStartDate(isset($data['startDate']) ? new \DateTime($data['startDate']) : null);

        return $dto;
    }
}
