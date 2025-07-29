<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Dto\HabilitationDto;

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
            $habilitations[] = HabilitationDto::fromArray($habilitation);
        }
        return $habilitations ?? [];
    }
}
