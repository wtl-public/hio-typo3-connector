<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Dto\PublicationDto;

class HioPublicationService extends HioApiService
{
    public function getPublications(int $page = 1): array {
        $apiResponse = $this->fetch($page);

        if ($apiResponse->getMeta()->getTotal() === 0) {
            return [];
        }

        $result = $apiResponse->getData();
        foreach ($result as $publication) {
            $releaseYear = $publication['journal']['releaseYear'] ?? null;
            $dto = PublicationDto::fromArray($publication);
            $dto->setReleaseYear($releaseYear);
            $publications[] = $dto;
        }
        return $publications??[];
    }
}
