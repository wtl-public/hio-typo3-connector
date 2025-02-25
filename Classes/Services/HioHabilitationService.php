<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Model\DTO\HabilitationDTO;

class HioHabilitationService extends HioApiService
{
    public function getHabilitations(int $page = 1): array
    {
        $apiResponse = $this->fetch($page);

        if ($apiResponse->getMeta()->getTotal() === 0) {
            return [];
        }

        $result = $apiResponse->getData();
        foreach ($result as $habilitation) {
            $dto  = new HabilitationDTO();
            $dto->setObjectId($habilitation['id']);
            $dto->setTitle($habilitation['title'] ?? '');
            $dto->setDetails($habilitation);
            $habilitations[] = $dto;
        }
        return $habilitations ?? [];
    }
}
