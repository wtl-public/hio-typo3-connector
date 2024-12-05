<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Model\DTO\PublicationDTO;

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
            $publicationData = new PublicationDTO();
            $publicationData->setObjectId($publication['id']);
            $publicationData->setTitle($publication['title']);
            $publicationData->setType($publication['type']);
            $publicationData->setReleaseYear($releaseYear);
            $publicationData->setDetails($publication);
            $publications[] = $publicationData;
        }
        return $publications??[];
    }
}
