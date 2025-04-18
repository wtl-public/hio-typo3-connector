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
            $publicationData = new PublicationDto();
            $publicationData->setObjectId($publication['id']);
            $publicationData->setTitle($publication['title']);
            $publicationData->setType($publication['type']);
            $publicationData->setReleaseYear((string)$releaseYear);
            $publicationData->setCitations($publication['citations'] ?? []);
            $publicationData->setDetails($publication);
            $publicationData->setSearchIndex($publication);
            $publications[] = $publicationData;
        }
        return $publications??[];
    }
}
