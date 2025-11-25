<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto;

use Wtl\HioTypo3Connector\Domain\Dto\DoctoralProgram\CourseOfStudyDto;
use Wtl\HioTypo3Connector\Domain\Dto\DoctoralProgram\DoctoralPositionAvailableDto;
use Wtl\HioTypo3Connector\Domain\Dto\DoctoralProgram\OrgUnitDto;
use Wtl\HioTypo3Connector\Domain\Dto\DoctoralProgram\PersonDto;
use Wtl\HioTypo3Connector\Domain\Dto\DoctoralProgram\ScholarshipAvailableDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\LanguageDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\ResearchAreaDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\ResearchAreaKdsfDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\SubjectAreaDto;
use Wtl\HioTypo3Connector\Trait\WithDescription;
use Wtl\HioTypo3Connector\Trait\WithDetails;
use Wtl\HioTypo3Connector\Trait\WithEndDate;
use Wtl\HioTypo3Connector\Trait\WithLanguage;
use Wtl\HioTypo3Connector\Trait\WithObjectId;
use Wtl\HioTypo3Connector\Trait\WithSearchIndex;
use Wtl\HioTypo3Connector\Trait\WithStartDate;
use Wtl\HioTypo3Connector\Trait\WithTitle;

class DoctoralProgramDto
{
    use WithDescription;
    use WithDetails;
    use WithEndDate;
    use WithLanguage;
    use WithObjectId;
    use WithSearchIndex;
    use WithStartDate;
    use WithTitle;

    protected ?CourseOfStudyDto $courseOfStudy;
    protected ?DoctoralPositionAvailableDto $doctoralPositionAvailable;

    /**
     * @var OrgUnitDto[]
     */
    protected array $orgUnits = [];
    /**
     * @var PersonDto[]
     */
    protected array $persons = [];
    /**
     * @var ResearchAreaDto[]
     */
    protected array $researchAreas = [];
    /**
     * @var ResearchAreaKdsfDto[]
     */
    protected array $researchAreasKdsf = [];
    protected ?ScholarshipAvailableDto $scholarshipAvailable;

    /**
     * @var SubjectAreaDto[]
     */
    protected array $subjectAreas = [];

    public function getCourseOfStudy(): ?CourseOfStudyDto
    {
        return $this->courseOfStudy;
    }

    public function setCourseOfStudy(?CourseOfStudyDto $courseOfStudy): void
    {
        $this->courseOfStudy = $courseOfStudy;
    }

    public function getDoctoralPositionAvailable(): ?DoctoralPositionAvailableDto
    {
        return $this->doctoralPositionAvailable;
    }

    public function setDoctoralPositionAvailable(?DoctoralPositionAvailableDto $doctoralPositionAvailable): void
    {
        $this->doctoralPositionAvailable = $doctoralPositionAvailable;
    }

    public function getSubjectAreas(): array
    {
        return $this->subjectAreas;
    }

    public function setSubjectAreas(array $subjectAreas): void
    {
        $this->subjectAreas = $subjectAreas;
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

    public function getPersons(): array
    {
        return $this->persons;
    }

    public function setPersons(array $persons): void
    {
        $this->persons = $persons;
    }

    public function getOrgUnits(): array
    {
        return $this->orgUnits;
    }

    public function setOrgUnits(array $orgUnits): void
    {
        $this->orgUnits = $orgUnits;
    }

    public function getScholarshipAvailable(): ?ScholarshipAvailableDto
    {
        return $this->scholarshipAvailable;
    }

    public function setScholarshipAvailable(?ScholarshipAvailableDto $scholarshipAvailable): void
    {
        $this->scholarshipAvailable = $scholarshipAvailable;
    }

    static public function fromArray(array $data): DoctoralProgramDto
    {
        $dto = new self();
        $dto->setObjectId($data['id']);
        $dto->setDetails($data);
        $dto->setSearchIndex($data);

        $dto->setCourseOfStudy(CourseOfStudyDto::fromArray($data['courseOfStudy']) ?? null);
        $dto->setDescription($data['description'] ?? '');
        $dto->setDoctoralPositionAvailable(DoctoralPositionAvailableDto::fromArray($data['doctoralPositionAvailable']) ?? null);
        $dto->setEndDate(isset($data['endDate']) ? new \DateTime($data['endDate']) : null);
        $dto->setLanguage(LanguageDto::fromArray($data['language']) ?? null);
        $dto->setSubjectAreas(array_map(fn($item) => SubjectAreaDto::fromArray($item), $data['subjectAreas'] ?? []));
        $dto->setResearchAreas(array_map(fn($item) => ResearchAreaDto::fromArray($item), $data['researchAreas'] ?? []));
        $dto->setResearchAreasKdsf(array_map(fn($item) => ResearchAreaKdsfDto::fromArray($item), $data['researchAreasKdsf'] ?? []));
        $dto->setPersons(array_map(fn($item) => PersonDto::fromArray($item), $data['persons'] ?? []));
        $dto->setOrgUnits(array_map(fn($item) => OrgUnitDto::fromArray($item), $data['organizations'] ?? []));
        $dto->setScholarshipAvailable(ScholarshipAvailableDto::fromArray($data['scholarshipAvailable']) ?? null);
        $dto->setStartDate(isset($data['startDate']) ? new \DateTime($data['startDate']) : null);
        $dto->setTitle($data['title'] ?? '');
        return $dto;
    }
}
