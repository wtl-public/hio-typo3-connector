<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\ResearchInfrastructure;

use Wtl\HioTypo3Connector\Domain\Dto\Misc\DocumentTypeDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\OpenAccessDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\StatusDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\VisibilityDto;
use Wtl\HioTypo3Connector\Domain\Dto\Publication\PublicationTypeDto;
use Wtl\HioTypo3Connector\Domain\Dto\ResearchInfrastructure\Publication\PeerReviewedDto;
use Wtl\HioTypo3Connector\Domain\Dto\ResearchInfrastructure\Publication\PublicationResourceDto;
use Wtl\HioTypo3Connector\Domain\Dto\ResearchInfrastructure\Publication\PublisherDto;
use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithStatus;
use Wtl\HioTypo3Connector\Trait\WithTitle;
use Wtl\HioTypo3Connector\Trait\WithType;
use Wtl\HioTypo3Connector\Trait\WithVisibility;

class PublicationDto
{
    use WithId;
    use WithStatus;
    use WithTitle;
    use WithType;
    use WithVisibility;

    protected ?string $abstract;
    protected ?DocumentTypeDto $documentType;
    protected ?OpenAccessDto $openAccess;
    protected ?PeerReviewedDto $peerReviewed;
    protected ?PublicationResourceDto $publicationResource;
    protected ?PublicationTypeDto $publicationType;
    protected ?PublisherDto $publisher;
    protected string $subtitle = '';

    public function getAbstract(): ?string
    {
        return $this->abstract;
    }

    public function setAbstract(?string $abstract): void
    {
        $this->abstract = $abstract;
    }

    public function getDocumentType(): ?DocumentTypeDto
    {
        return $this->documentType;
    }

    public function setDocumentType(?DocumentTypeDto $documentType): void
    {
        $this->documentType = $documentType;
    }

    public function getOpenAccess(): ?OpenAccessDto
    {
        return $this->openAccess;
    }

    public function setOpenAccess(?OpenAccessDto $openAccess): void
    {
        $this->openAccess = $openAccess;
    }

    public function getPeerReviewed(): ?PeerReviewedDto
    {
        return $this->peerReviewed;
    }

    public function setPeerReviewed(?PeerReviewedDto $peerReviewed): void
    {
        $this->peerReviewed = $peerReviewed;
    }

    public function getPublicationResource(): ?PublicationResourceDto
    {
        return $this->publicationResource;
    }

    public function setPublicationResource(?PublicationResourceDto $publicationResource): void
    {
        $this->publicationResource = $publicationResource;
    }

    public function getPublicationType(): ?PublicationTypeDto
    {
        return $this->publicationType;
    }

    public function setPublicationType(?PublicationTypeDto $publicationType): void
    {
        $this->publicationType = $publicationType;
    }

    public function getPublisher(): ?PublisherDto
    {
        return $this->publisher;
    }

    public function setPublisher(?PublisherDto $publisher): void
    {
        $this->publisher = $publisher;
    }

    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): void
    {
        $this->subtitle = $subtitle;
    }

    public static function fromArray(array $data): ?self
    {
        if( empty($data)) {
            return null;
        }
        $dto = new self();
        $dto->setAbstract($data['abstract'] ?? null);
        $dto->setDocumentType(is_array($data['documentType']) ? DocumentTypeDto::fromArray($data['documentType']) : null);
        $dto->setId($data['id'] ?? null);
        $dto->setOpenAccess(is_array($data['openAccess']) ? OpenAccessDto::fromArray($data['openAccess']) : null);
        $dto->setPeerReviewed(is_array($data['peerReviewed']) ? PeerReviewedDto::fromArray($data['peerReviewed']) : null);
        $dto->setPublicationResource(is_array($data['publicationResource']) ? PublicationResourceDto::fromArray($data['publicationResource']) : null);
        $dto->setPublicationType(is_array($data['publicationType']) ? PublicationTypeDto::fromArray($data['publicationType']) : null);
        $dto->setPublisher(is_array($data['publisher']) ? PublisherDto::fromArray($data['publisher']) : null);
        $dto->setStatus(is_array($data['status']) ? StatusDto::fromArray($data['status']) : null);
        $dto->setSubtitle($data['subtitle'] ?? '');
        $dto->setTitle($data['title'] ?? '');
        $dto->setType($data['type'] ?? '');
        $dto->setVisibility(is_array($data['visibility']) ? VisibilityDto::fromArray($data['visibility']) : null);

        return $dto;
    }
}
