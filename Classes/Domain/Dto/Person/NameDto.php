<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Person;

class  NameDto
{
    protected ?string $academicDegree = null;
    protected ?string $academicDegreeSuffix = null;

    protected ?string $artistName = null;
    protected string $displayName = '';
    protected string $firstName = '';
    protected string $lastName = '';
    protected ?string $namePrefix = null;
    protected ?string $nameSuffix = null;

    protected ?string $title = null;

    public function getAcademicDegree(): ?string
    {
        return $this->academicDegree;
    }

    public function setAcademicDegree(?string $academicDegree): void
    {
        $this->academicDegree = $academicDegree;
    }

    public function getAcademicDegreeSuffix(): ?string
    {
        return $this->academicDegreeSuffix;
    }

    public function setAcademicDegreeSuffix(?string $academicDegreeSuffix): void
    {
        $this->academicDegreeSuffix = $academicDegreeSuffix;
    }

    public function getArtistName(): ?string
    {
        return $this->artistName;
    }

    public function setArtistName(?string $artistName): void
    {
        $this->artistName = $artistName;
    }

    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    public function setDisplayName(string $displayName): void
    {
        $this->displayName = $displayName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getNamePrefix(): ?string
    {
        return $this->namePrefix;
    }

    public function setNamePrefix(?string $namePrefix): void
    {
        $this->namePrefix = $namePrefix;
    }

    public function getNameSuffix(): ?string
    {
        return $this->nameSuffix;
    }

    public function setNameSuffix(?string $nameSuffix): void
    {
        $this->nameSuffix = $nameSuffix;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    static public function fromArray(array $data): NameDto
    {
        $dto = new self();

        $dto->setTitle($data['title'] ?? null);
        $dto->setAcademicDegree($data['academicDegree'] ?? null);
        $dto->setAcademicDegreeSuffix($data['academicDegreeSuffix'] ?? null);
        $dto->setArtistName($data['artistName'] ?? null);
        $dto->setDisplayName($data['displayName'] ?? '');
        $dto->setFirstName($data['firstName'] ?? '');
        $dto->setLastName($data['lastName'] ?? '');
        $dto->setNamePrefix($data['namePrefix'] ?? null);
        $dto->setNameSuffix($data['nameSuffix'] ?? null);
        return $dto;
    }
}
