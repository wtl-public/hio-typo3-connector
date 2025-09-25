<?php

namespace Wtl\HioTypo3Connector\Controller;

use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use Wtl\HioTypo3Connector\Domain\Dto\Filter\FilterDto;
use Wtl\HioTypo3Connector\Domain\Model\Publication;

class BaseController extends AbstractController
{
    protected function getCurrentPageNumberFromRequest(): int
    {
        return $this->request->hasArgument('currentPageNumber')
            ? (int)$this->request->getArgument('currentPageNumber')
            : 1;
    }

    protected function getFilterFromRequest(): FilterDto
    {
        $filter = new FilterDto();
        if ($this->request->hasArgument('filter')) {
            $filter = $this->request->getArgument('filter');
            if (! $filter instanceof FilterDto) {
                try {
                    $filter = FilterDto::fromRequest($this->request);
                }
                catch (\Throwable $e) {
                    $this->logger->error(
                        'Failed to parse filter from request: ' . $e->getMessage(),
                        ['exception' => $e]
                    );
                    $filter = new FilterDto();
                }
            }
        }
        return $filter;
    }

    protected function getPaginator(QueryResultInterface $queryResult, int $resultsPerPage = 10): QueryResultPaginator
    {
        return new QueryResultPaginator(
            $queryResult,
            $this->getCurrentPageNumberFromRequest(),
            $resultsPerPage,
        );
    }

    protected function getPublicationOrderingFromProperty(string $property): array
    {
        $orderings = [];
        $orderBy = $this->settings[$property] ?? '';
        if ($orderBy !== '') {
            [$propertyName, $order] = explode(':', $orderBy);
            if (in_array($propertyName, Publication::ORDERABLE_COLUMNS)) {
                $orderings = [$propertyName => $order];
            }
        }

        return $orderings;
    }
}
