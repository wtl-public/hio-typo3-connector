<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto;

use Wtl\HioTypo3Connector\Domain\Dto\Misc\StatusDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\VisibilityDto;
use Wtl\HioTypo3Connector\Domain\Dto\Patent\CountryOfRegistrationDto;
use Wtl\HioTypo3Connector\Domain\Dto\Patent\PersonDto;
use Wtl\HioTypo3Connector\Domain\Dto\Patent\PriorityPatentDto;
use Wtl\HioTypo3Connector\Trait\WithDescription;
use Wtl\HioTypo3Connector\Trait\WithDetails;
use Wtl\HioTypo3Connector\Trait\WithObjectId;
use Wtl\HioTypo3Connector\Trait\WithSearchIndex;
use Wtl\HioTypo3Connector\Trait\WithStatus;
use Wtl\HioTypo3Connector\Trait\WithTitle;
use Wtl\HioTypo3Connector\Trait\WithVisibility;

class PatentDto
{
    use WithDetails;
    use WithDescription;
    use WithObjectId;
    use WithSearchIndex;
    use WithStatus;
    use WithTitle;
    use WithVisibility;

    protected ?CountryOfRegistrationDto $countryOfRegistration;
    protected ?\DateTime $grantDate = null;
    /**
     * @var PersonDto[]
     */
    protected array $persons = [];
    protected string $patentNumber = '';
    protected ?PriorityPatentDto $priorityPatent;
    protected ?string $publicationNumber = null;

    protected ?\DateTime $registrationDate = null;
    /**
     * @var string[]
     */
    protected array $researchAreas = [];
    /**
     * @var string[]
     */
    protected array $subjectAreas = [];

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

    public function getPatentNumber(): string
    {
        return $this->patentNumber;
    }

    public function setPatentNumber(string $patentNumber): void
    {
        $this->patentNumber = $patentNumber;
    }

    public function getPriorityPatent(): ?PriorityPatentDto
    {
        return $this->priorityPatent;
    }

    public function setPriorityPatent(?PriorityPatentDto $priorityPatent): void
    {
        $this->priorityPatent = $priorityPatent;
    }

    public function getCountryOfRegistration(): ?CountryOfRegistrationDto
    {
        return $this->countryOfRegistration;
    }

    public function setCountryOfRegistration(?CountryOfRegistrationDto $countryOfRegistration): void
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

        $patentDto->setCountryOfRegistration(isset($data['countryOfRegistration']) ? CountryOfRegistrationDto::fromArray($data['countryOfRegistration']) : null);
        $patentDto->setDescription($data['description'] ?? '');
        $patentDto->setGrantDate(isset($data['grantDate']) ? new \DateTime($data['grantDate']) : null);
        $patentDto->setPatentNumber($data['patentNumber'] ?? '');
        $patentDto->setPersons(array_map(fn($item) => PersonDto::fromArray($item), $data['persons'] ?? []));
        $patentDto->setPriorityPatent(isset($data['priorityPatent']) ? PriorityPatentDto::fromArray($data['priorityPatent']) : null);
        $patentDto->setPublicationNumber($data['publicationNumber'] ?? null);
        $patentDto->setRegistrationDate(isset($data['registrationDate']) ? new \DateTime($data['registrationDate']) : null);
        $patentDto->setResearchAreas($data['researchAreas'] ?? []);
        $patentDto->setStatus(isset($data['status']) ? StatusDto::fromArray($data['status']) : null);
        $patentDto->setSubjectAreas($data['subjectAreas'] ?? []);
        $patentDto->setTitle($data['title'] ?? '');
        $patentDto->setVisibility(isset($data['visibility']) ? VisibilityDto::fromArray($data['visibility']) : null);

        return $patentDto;
    }
}
