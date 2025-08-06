<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Dto\SpinOffDto;

class HioSpinOffService extends HioApiService
{
    public function getSpinOffs(int $page = 1): array
    {
        $apiResponse = $this->fetch($page);

        if ($apiResponse->getMeta()->getTotal() === 0) {
            return [];
        }

        $result = $apiResponse->getData();
        foreach ($result as $spinOff) {
            $spinOffs[] = SpinOffDto::fromArray($spinOff);
        }
        return $spinOffs ?? [];
    }
}
