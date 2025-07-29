<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Dto\DoctoralProgramDto;

class HioDoctoralProgramService extends HioApiService
{
    public function getDoctoralPrograms(int $page = 1): array
    {
        $apiResponse = $this->fetch($page);

        if ($apiResponse->getMeta()->getTotal() === 0) {
            return [];
        }

        $result = $apiResponse->getData();
        foreach ($result as $doctoralProgram) {
            $doctoralPrograms[] = DoctoralProgramDto::fromArray($doctoralProgram);
        }
        return $doctoralPrograms ?? [];
    }
}
