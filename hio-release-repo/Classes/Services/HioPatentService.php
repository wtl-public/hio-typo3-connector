<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Dto\PatentDto;

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
            $projects[] = PatentDto::fromArray($patent);
        }
        return $projects ?? [];
    }
}
