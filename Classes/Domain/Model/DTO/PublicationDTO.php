<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model\DTO;

use Wtl\HioTypo3Connector\Domain\Model\DTO\Publication\ConferenceDTO;
use Wtl\HioTypo3Connector\Domain\Model\DTO\Publication\CitationDTO;
use Wtl\HioTypo3Connector\Domain\Model\DTO\Publication\GlobalIdentifierDTO;
use Wtl\HioTypo3Connector\Domain\Model\DTO\Publication\JournalDTO;
use Wtl\HioTypo3Connector\Domain\Model\DTO\Publication\LanguageDTO;
use Wtl\HioTypo3Connector\Domain\Model\DTO\Publication\PersonDTO;
use Wtl\HioTypo3Connector\Domain\Model\Publication;

class PublicationDTO extends BaseDTO
{
    protected string $abstract = '';
    protected string $access = '';
    /*
     * @var CitationDTO[]
     */
    protected array $citations = [];
    protected ?ConferenceDTO $conference = null;
    protected string $document = '';
    /**
     * @var GlobalIdentifierDTO[]
     */
    protected array $globalIdentifiers;
    protected ?JournalDTO $journal = null;
    /**
     * @var string[]
     */
    protected array $keywords = [];
    /*
         *  @var LanguageDTO[]
         */
    protected array $languages = [];
    /**
     * @var PersonDTO[]
     */
    protected array $persons = [];
    protected ?string $releaseYear = null;
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

    public function getJournal(): ?JournalDTO
    {
        return $this->journal;
    }
    public function setJournal(?JournalDTO $journal): void
    {
        $this->journal = $journal;
    }

    public function getConference(): ?ConferenceDTO
    {
        return $this->conference;
    }
    public function setConference(?ConferenceDTO $conference): void
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

    public function getAccess(): string
    {
        return $this->access;
    }
    public function setAccess(string $access): void
    {
        $this->access = $access;
    }

    public function getReleaseYear(): ?string
    {
        return $this->releaseYear;
    }
    public function setReleaseYear(?string $releaseYear): void
    {
        $this->releaseYear = $releaseYear;
    }

    static public function fromDomainModel(Publication|\TYPO3\CMS\Extbase\DomainObject\AbstractEntity $model): static
    {
        $details = $model->getDetails();

        $persons = $details['persons'] ?? [];
        $personData = [];
        foreach ($persons as $person) {
            $personData[] = PersonDTO::fromArray($person);
        }

        $globalIdentifiers = $details['globalIdentifiers'] ?? [];
        $globalIdentifierData = [];
        foreach ($globalIdentifiers as $globalIdentifier) {
            $globalIdentifierData[] = GlobalIdentifierDTO::fromArray($globalIdentifier);
        }

        $languages = $details['languages'] ?? [];
        $languageData = [];
        foreach ($languages as $language) {
            $languageData[] = LanguageDTO::fromArray($language);
        }

        $citations = $details['citations'] ?? [];
        $citationData = [];
        foreach ($citations as $citation) {
            $citationData[] = CitationDTO::fromArray($citation);
        }

        $publicationData = new self();
        $publicationData->setExtbaseUid($model->getUid());
        $publicationData->setReleaseYear($model->getReleaseYear());
        $publicationData->setDetails($details);
        $publicationData->setCitations($citationData);
        $publicationData->setTitle($details['title']);
        $publicationData->setSubtitle($details['subtitle'] ?? '');
        $publicationData->setAbstract($details['abstract'] ?? '');
        $publicationData->setType($details['type']);
        $publicationData->setDocument($details['document'] ?? '');
        $publicationData->setResource($details['resource'] ?? '');
        $publicationData->setReviewed($details['reviewed'] ?? '');
        $publicationData->setVisibility($details['visibility'] ?? '');
        $publicationData->setStatus($details['status'] ?? '');
        $publicationData->setAccess($details['access'] ?? '');
        $publicationData->setObjectId($details['id']);
        $publicationData->setPersons($personData);
        if (isset($details['journal'])) {
            $publicationData->setJournal(JournalDTO::fromArray($details['journal']));
        }
        if (isset($details['conference'])) {
            $publicationData->setConference(ConferenceDTO::fromArray($details['conference']));
        }
        $publicationData->setLanguages($languageData);
        $publicationData->setGlobalIdentifiers($globalIdentifierData);
        $publicationData->setKeywords($details['keywords'] ?? []);
        return $publicationData;
    }

    static public function fromArray(array $data): PublicationDTO
    {
        $releaseYear = $publication['journal']['releaseYear'] ?? null;
        $dto = new self();
        $dto->setObjectId($data['id']);
        $dto->setTitle($data['title']);
        $dto->setType($data['type']);
        $dto->setReleaseYear($releaseYear);
        $dto->setCitations($data['citations'] ?? []);
        $dto->setDetails($data);
        $dto->setSearchIndex($data);
        return $dto;
    }
}
