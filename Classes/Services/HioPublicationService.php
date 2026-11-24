<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Dto\PublicationDto;

class HioPublicationService extends HioApiService
{
    /**
     * @param (callable(?int, \Throwable): void)|null $onMappingFailure
     * @return PublicationDto[]
     */
    public function getPublications(int $page = 1, ?callable $onMappingFailure = null): array
    {
        return $this->fetchMappedPage(
            $page,
            static function (array $publication): PublicationDto {
                $dto = PublicationDto::fromArray($publication);
                $dto->setReleaseYear($publication['journal']['releaseYear'] ?? null);
                return $dto;
            },
            $onMappingFailure
        );
    }
}
