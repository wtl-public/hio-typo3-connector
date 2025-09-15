<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto;

use Wtl\HioTypo3Connector\Domain\Dto\Patent\PersonDto;
use Wtl\HioTypo3Connector\Trait\WithDetails;
use Wtl\HioTypo3Connector\Trait\WithObjectId;
use Wtl\HioTypo3Connector\Trait\WithSearchIndex;

class PatentDto
{
    use WithObjectId;
    use WithDetails;
    use WithSearchIndex;

    protected string $countryOfRegistration = '';
    protected string $description = '';
    protected ?\DateTime $grantDate = null;
    /**
     * @var PersonDto[]
     */
    protected array $persons = [];
    protected string $patentNumber = '';
    protected ?bool $priorityPatent = null;
    protected ?string $publicationNumber = null;

    protected ?\DateTime $registrationDate = null;
    /**
     * @var string[]
     */
    protected array $researchAreas = [];
    protected string $status = '';
    /**
     * @var string[]
     */
    protected array $subjectAreas = [];
    protected string $title = '';
    protected string $visibility = '';

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getVisibility(): string
    {
        return $this->visibility;
    }
    public function setVisibility(string $visibility): void
    {
        $this->visibility = $visibility;
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

    public function getPersons(): array
    {
        return $this->persons;
    }
    public function setPersons(array $persons): void
    {
        $this->persons = $persons;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPatentNumber(): string
    {
        return $this->patentNumber;
    }

    public function setPatentNumber(string $patentNumber): void
    {
        $this->patentNumber = $patentNumber;
    }

    public function getPriorityPatent(): ?bool
    {
        return $this->priorityPatent;
    }

    public function setPriorityPatent(?bool $priorityPatent): void
    {
        $this->priorityPatent = $priorityPatent;
    }

    public function getCountryOfRegistration(): string
    {
        return $this->countryOfRegistration;
    }

    public function setCountryOfRegistration(string $countryOfRegistration): void
    {
        $this->countryOfRegistration = $countryOfRegistration;
    }

    public function getPublicationNumber(): ?string
    {
        return $this->publicationNumber;
    }
    public function setPublicationNumber(?string $publicationNumber): void
    {
        $this->publicationNumber = $publicationNumber;
    }

    public function getGrantDate(): ?\DateTime
    {
        return $this->grantDate;
    }
    public function setGrantDate(?\DateTime $grantDate): void
    {
        $this->grantDate = $grantDate;
    }

    public function getRegistrationDate(): ?\DateTime
    {
        return $this->registrationDate;
    }
    public function setRegistrationDate(?\DateTime $registrationDate): void
    {
        $this->registrationDate = $registrationDate;
    }

    static public function fromArray(array $data): PatentDto
    {
        $patentDto = new self();
        $patentDto->setObjectId($data['id']);
        $patentDto->setDetails($data);
        $patentDto->setSearchIndex($data);

        $patentDto->setCountryOfRegistration($data['countryOfRegistration'] ?? '');
        $patentDto->setDescription($data['description'] ?? '');
        $patentDto->setGrantDate(isset($data['grantDate']) ? new \DateTime($data['grantDate']) : null);
        $patentDto->setPatentNumber($data['patentNumber'] ?? '');
        $patentDto->setPersons(array_map(fn($item) => PersonDto::fromArray($item), $data['persons'] ?? []));
        $patentDto->setPriorityPatent($data['priorityPatent'] ?? null);
        $patentDto->setPublicationNumber($data['publicationNumber'] ?? null);
        $patentDto->setRegistrationDate(isset($data['registrationDate']) ? new \DateTime($data['registrationDate']) : null);
        $patentDto->setResearchAreas($data['researchAreas'] ?? []);
        $patentDto->setStatus($data['status'] ?? '');
        $patentDto->setSubjectAreas($data['subjectAreas'] ?? []);
        $patentDto->setTitle($data['title'] ?? '');
        $patentDto->setVisibility($data['visibility'] ?? '');

        return $patentDto;
    }
}
