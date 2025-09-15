<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto;

use Wtl\HioTypo3Connector\Domain\Dto\Publication\AttributeDto;
use Wtl\HioTypo3Connector\Domain\Dto\Publication\ConferenceDto;
use Wtl\HioTypo3Connector\Domain\Dto\Publication\GlobalIdentifierDto;
use Wtl\HioTypo3Connector\Domain\Dto\Publication\JournalDto;
use Wtl\HioTypo3Connector\Domain\Dto\Publication\PersonDto;
use Wtl\HioTypo3Connector\Trait\WithDetails;
use Wtl\HioTypo3Connector\Trait\WithObjectId;
use Wtl\HioTypo3Connector\Trait\WithSearchIndex;

class PublicationDto
{
    use WithObjectId;
    use WithDetails;
    use WithSearchIndex;

    protected string $abstract = '';
    protected string $openAccess = '';
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
    /**
     * @var string[]
     */
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
    protected string $resource = '';
    protected string $reviewed = '';
    protected string $status = '';
    protected string $subtitle = '';
    protected string $title = '';
    protected string $type = '';
    protected string $visibility = '';

    public function getCitations(): array
    {
        return $this->citations;
    }
    public function setCitations(array $citations): void
    {
        $this->citations = $citations;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function getSubtitle(): string
    {
        return $this->subtitle;
    }
    public function getAbstract(): string
    {
        return $this->abstract;
    }
    public function getType(): string
    {
        return $this->type;
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
    public function setType(string $type): void
    {
        $this->type = $type;
    }
    public function setDocument(string $document): void
    {
        $this->document = $document;
    }
    public function setResource(string $resource): void
    {
        $this->resource = $resource;
    }
    public function setReviewed(string $reviewed): void
    {
        $this->reviewed = $reviewed;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
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

    public function getVisibility(): string
    {
        return $this->visibility;
    }
    public function setVisibility(string $visibility): void
    {
        $this->visibility = $visibility;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getOpenAccess(): string
    {
        return $this->openAccess;
    }
    public function setOpenAccess(string $openAccess): void
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
        $dto->setOpenAccess($data['openAccess'] ?? '');
        $dto->setPersons(array_map(fn($item) => PersonDto::fromArray($item), $data['persons'] ?? []));
        $dto->setReleaseYear($data['releaseYear'] ?? null);
        $dto->setStatus($data['status'] ?? '');
        $dto->setTitle($data['title']);
        $dto->setType($data['type']);
        $dto->setVisibility($data['visibility'] ?? '');
        return $dto;
    }
}
