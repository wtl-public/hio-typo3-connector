<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model\DTO\Project;

class SubjectAreaDTO
{
    protected int $id;
    protected string $name;

    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public static function fromArray(array $data): self
    {
        $subjectArea = new self();
        $subjectArea->setId($data['id']);
        $subjectArea->setName($data['name']);
        return $subjectArea;
    }
}
