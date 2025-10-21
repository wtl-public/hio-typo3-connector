<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto;

use Wtl\HioTypo3Connector\Domain\Dto\Misc\OpenAccessDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\ResearchAreaDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\ResearchAreaKdsfDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\StatusDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\SubjectAreaDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\VisibilityDto;
use Wtl\HioTypo3Connector\Domain\Dto\Publication\ConferenceDto;
use Wtl\HioTypo3Connector\Domain\Dto\Publication\GlobalIdentifierDto;
use Wtl\HioTypo3Connector\Domain\Dto\Publication\JournalDto;
use Wtl\HioTypo3Connector\Domain\Dto\Publication\KeywordDto;
use Wtl\HioTypo3Connector\Domain\Dto\Publication\PersonDto;
use Wtl\HioTypo3Connector\Trait\WithDetails;
use Wtl\HioTypo3Connector\Trait\WithObjectId;
use Wtl\HioTypo3Connector\Trait\WithSearchIndex;
use Wtl\HioTypo3Connector\Trait\WithStatus;
use Wtl\HioTypo3Connector\Trait\WithTitle;
use Wtl\HioTypo3Connector\Trait\WithType;
use Wtl\HioTypo3Connector\Trait\WithVisibility;

class PublicationDto
{
    use WithObjectId;
    use WithDetails;
    use WithSearchIndex;
    use WithStatus;
    use WithTitle;
    use WithType;
    use WithVisibility;

    protected string $abstract = '';
    protected ?OpenAccessDto $openAccess = null;
    /*
     * @var CitationDto[]
     */
    protected array $citations = [];
    protected ?ConferenceDto $conference = null;
    protected string $document = '';
    /**
     * @var GlobalIdentifierDto[]
     */
    protected array $globalIdentifiers;
    protected ?JournalDto $journal = null;
    protected array $keywords = [];
    /*
         *  @var LanguageDto[]
         */
    protected array $languages = [];
    /**
     * @var PersonDto[]
     */
    protected array $persons = [];
    protected ?int $releaseYear = null;
    protected array $researchAreas = [];
    protected array $researchAreasKdsf = [];

    protected string $resource = '';
    protected string $reviewed = '';
    protected array $subjectAreas = [];
    protected string $subtitle = '';

    public function getCitations(): array
    {
        return $this->citations;
    }
    public function setCitations(array $citations): void
    {
        $this->citations = $citations;
    }
    public function getSubtitle(): string
    {
        return $this->subtitle;
    }
    public function getAbstract(): string
    {
        return $this->abstract;
    }
    public function getDocument(): string
    {
        return $this->document;
    }
    public function getResource(): string
    {
        return $this->resource;
    }
    public function getReviewed(): string
    {
        return $this->reviewed;
    }
    public function setSubtitle(string $subtitle): void
    {
        $this->subtitle = $subtitle;
    }
    public function setAbstract(string $abstract): void
    {
        $this->abstract = $abstract;
    }
    public function setDocument(string $document): void
    {
        $this->document = $document;
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

    public function setResource(string $resource): void
    {
        $this->resource = $resource;
    }
    public function setReviewed(string $reviewed): void
    {
        $this->reviewed = $reviewed;
    }
    public function getPersons(): array
    {
        return $this->persons;
    }
    public function setPersons(array $persons): void
    {
        $this->persons = $persons;
    }

    public function getJournal(): ?JournalDto
    {
        return $this->journal;
    }
    public function setJournal(?JournalDto $journal): void
    {
        $this->journal = $journal;
    }

    public function getConference(): ?ConferenceDto
    {
        return $this->conference;
    }
    public function setConference(?ConferenceDto $conference): void
    {
        $this->conference = $conference;
    }

    public function getLanguages(): array
    {
        return $this->languages;
    }
    public function setLanguages(array $languages): void
    {
        $this->languages = $languages;
    }

    public function getKeywords(): array
    {
        return $this->keywords;
    }
    public function setKeywords(array $keywords): void
    {
        $this->keywords = $keywords;
    }

    public function getGlobalIdentifiers(): array
    {
        return $this->globalIdentifiers;
    }
    public function setGlobalIdentifiers(array $globalIdentifiers): void
    {
        $this->globalIdentifiers = $globalIdentifiers;
    }

    public function getOpenAccess(): ?OpenAccessDto
    {
        return $this->openAccess;
    }
    public function setOpenAccess(?OpenAccessDto $openAccess): void
    {
        $this->openAccess = $openAccess;
    }

    public function getReleaseYear(): ?int
    {
        return $this->releaseYear;
    }
    public function setReleaseYear(?int $releaseYear): void
    {
        $this->releaseYear = $releaseYear;
    }

    static public function fromArray(array $data): PublicationDto
    {
        $dto = new self();
        $dto->setObjectId($data['id']);
        $dto->setDetails($data);
        $dto->setSearchIndex($data);

        $dto->setAbstract($data['abstract'] ?? '');
        $dto->setCitations($data['citations'] ?? []);
        if ($data['openAccess']) {
            $dto->setOpenAccess(OpenAccessDto::fromArray($data['openAccess']));
        }
        $dto->setKeywords(array_map(fn($item) => KeywordDto::fromArray($item), $data['keywords'] ?? []));
        $dto->setPersons(array_map(fn($item) => PersonDto::fromArray($item), $data['persons'] ?? []));
        $dto->setReleaseYear($data['releaseYear'] ?? null);
        $dto->setResearchAreas(array_map(fn($item) => ResearchAreaDto::fromArray($item), $data['researchAreas'] ?? []));
        $dto->setResearchAreasKdsf(array_map(fn($item) => ResearchAreaKdsfDto::fromArray($item), $data['researchAreasKdsf'] ?? []));
        $dto->setStatus(StatusDto::fromArray($data['status']) ?? null);
        $dto->setSubjectAreas(array_map(fn($item) => SubjectAreaDto::fromArray($item), $data['subjectAreas'] ?? []));
        $dto->setTitle($data['title']);
        $dto->setType($data['type']);
        $dto->setVisibility(VisibilityDto::fromArray($data['visibility']) ?? null);
        return $dto;
    }
}
