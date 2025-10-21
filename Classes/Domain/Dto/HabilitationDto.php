<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto;

use Wtl\HioTypo3Connector\Domain\Dto\Habilitation\OrgUnitDto;
use Wtl\HioTypo3Connector\Domain\Dto\Habilitation\PersonDto;
use Wtl\HioTypo3Connector\Trait\WithDetails;
use Wtl\HioTypo3Connector\Trait\WithEndDate;
use Wtl\HioTypo3Connector\Trait\WithLanguage;
use Wtl\HioTypo3Connector\Trait\WithObjectId;
use Wtl\HioTypo3Connector\Trait\WithSearchIndex;
use Wtl\HioTypo3Connector\Trait\WithStartDate;
use Wtl\HioTypo3Connector\Trait\WithStatus;
use Wtl\HioTypo3Connector\Trait\WithTitle;
use Wtl\HioTypo3Connector\Trait\WithType;

class HabilitationDto
{
    use WithEndDate;
    use WithLanguage;
    use WithObjectId;
    use WithDetails;
    use WithSearchIndex;
    use WithStartDate;
    use WithStatus;
    use WithTitle;
    use WithType;

    protected ?\DateTime $admissionDate = null;
    protected ?\DateTime $certificateDate = null;
    protected ?\DateTime $endDate = null;

    /**
     * @var OrgUnitDto[]
     */
    protected array $orgUnits = [];
    /**
     * @var PersonDto[]
     */
    protected array $persons = [];
    protected ?\DateTime $registrationDate = null;
    /**
     * @var string[]
     */
    protected array $researchAreas = [];
    protected ?\DateTime $startDate = null;
    protected array $subjectAreas = [];

    public function getAdmissionDate(): ?\DateTime
    {
        return $this->admissionDate;
    }
    public function setAdmissionDate(?\DateTime $admissionDate): void
    {
        $this->admissionDate = $admissionDate;
    }

    public function getCertificateDate(): ?\DateTime
    {
        return $this->certificateDate;
    }
    public function setCertificateDate(?\DateTime $certificateDate): void
    {
        $this->certificateDate = $certificateDate;
    }

    public function getOrgUnits(): array
    {
        return $this->orgUnits;
    }
    public function setOrgUnits(array $orgUnits): void
    {
        $this->orgUnits = $orgUnits;
    }

    public function getPersons(): array
    {
        return $this->persons;
    }
    public function setPersons(array $persons): void
    {
        $this->persons = $persons;
    }

    public function getRegistrationDate(): ?\DateTime
    {
        return $this->registrationDate;
    }
    public function setRegistrationDate(?\DateTime $registrationDate): void
    {
        $this->registrationDate = $registrationDate;
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

    static public function fromArray(array $data): HabilitationDto
    {
        $habilitationDto = new self();
        $habilitationDto->setObjectId($data['id']);
        $habilitationDto->setDetails($data);
        $habilitationDto->setSearchIndex($data);

        if (isset($data['admissionDate'])) {
            $habilitationDto->setAdmissionDate(new \DateTime($data['admissionDate']));
        }
        if (isset($data['certificateDate'])) {
            $habilitationDto->setCertificateDate(new \DateTime($data['certificateDate']));
        }
        if (isset($data['endDate'])) {
            $habilitationDto->setEndDate(new \DateTime($data['endDate']));
        }
        $habilitationDto->setOrgUnits(array_map(fn($item) => OrgUnitDto::fromArray($item), $data['persons'] ?? []));
        $habilitationDto->setPersons(array_map(fn($item) => PersonDto::fromArray($item), $data['persons'] ?? []));

        if (isset($data['registrationDate'])) {
            $habilitationDto->setRegistrationDate(new \DateTime($data['registrationDate']));
        }
        if (isset($data['startDate'])) {
            $habilitationDto->setStartDate(new \DateTime($data['startDate']));
        }
        $habilitationDto->setTitle($data['title']);
        $habilitationDto->setType($data['type'] ?? '');

        return $habilitationDto;
    }
}
