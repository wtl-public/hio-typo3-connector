<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Model\DTO\PatentDTO;

class HioPatentService extends HioApiService
{
    public function getPatents(int $page = 1): array
    {
        $apiResponse = $this->fetch($page);

        if ($apiResponse->getMeta()->getTotal() === 0) {
            return [];
        }

        $result = $apiResponse->getData();
        foreach ($result as $patent) {
            $dto  = new PatentDTO();
            $dto->setObjectId($patent['id']);
            $dto->setTitle($patent['title'] ?? '');
            $dto->setDetails($patent);
            $dto->setSearchIndex(strtolower($patent));
            $projects[] = $dto;
        }
        return $projects ?? [];
    }
}
