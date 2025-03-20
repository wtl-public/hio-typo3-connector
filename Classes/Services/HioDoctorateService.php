<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Model\DTO\DoctorateDTO;

class HioDoctorateService extends HioApiService
{
    public function getDoctorates(int $page = 1): array
    {
        $apiResponse = $this->fetch($page);

        if ($apiResponse->getMeta()->getTotal() === 0) {
            return [];
        }

        $result = $apiResponse->getData();
        foreach ($result as $doctorate) {
            $dto  = new DoctorateDTO();
            $dto->setObjectId($doctorate['id']);
            $dto->setTitle($doctorate['title'] ?? '');
            $dto->setDetails($doctorate);
            $dto->setSearchIndex(strtolower($doctorate));
            $doctorates[] = $dto;
        }
        return $doctorates ?? [];
    }
}
