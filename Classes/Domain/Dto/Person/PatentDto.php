<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Person;

class PatentDto
{
    protected ?string $description = null;
    protected ?\DateTime $grantDate = null;
    protected int $id;
    protected string $patentNumber = '';
    protected ?\DateTime $registrationDate = null;
    protected string $status = '';
    protected string $title = '';
    protected string $visibility = '';

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getGrantDate(): ?\DateTime
    {
        return $this->grantDate;
    }

    public function setGrantDate(?\DateTime $grantDate): void
    {
        $this->grantDate = $grantDate;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getPatentNumber(): string
    {
        return $this->patentNumber;
    }

    public function setPatentNumber(string $patentNumber): void
    {
        $this->patentNumber = $patentNumber;
    }

    public function getRegistrationDate(): ?\DateTime
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(?\DateTime $registrationDate): void
    {
        $this->registrationDate = $registrationDate;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getVisibility(): string
    {
        return $this->visibility;
    }

    public function setVisibility(string $visibility): void
    {
        $this->visibility = $visibility;
    }

    static public function fromArray(array $data): self
    {
        $dto = new self();
        $dto->setDescription($data['description'] ?? '');
        $dto->setGrantDate(isset($data['grantDate']) ? new \DateTime($data['grantDate']) : null);
        $dto->setId($data['id']);
        $dto->setPatentNumber($data['patentNumber'] ?? '');
        $dto->setRegistrationDate(isset($data['registrationDate']) ? new \DateTime($data['registrationDate']) : null);
        $dto->setStatus($data['status'] ?? '');
        $dto->setTitle($data['title']);
        $dto->setVisibility($data['visibility'] ?? '');
        return $dto;
    }
}
