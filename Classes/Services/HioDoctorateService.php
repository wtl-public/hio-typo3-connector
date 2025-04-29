<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Dto\DoctorateDto;

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
            $doctorates[] = DoctorateDto::fromArray($doctorate);
        }
        return $doctorates ?? [];
    }
}
