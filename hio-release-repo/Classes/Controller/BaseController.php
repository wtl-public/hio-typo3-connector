<?php

namespace Wtl\HioTypo3Connector\Controller;

use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use Wtl\HioTypo3Connector\Controller\AbstractController;

class BaseController extends AbstractController
{
    protected function getCurrentPageNumberFromRequest(): int
    {
        return $this->request->hasArgument('currentPageNumber')
            ? (int)$this->request->getArgument('currentPageNumber')
            : 1;
    }

    protected function getSearchTermFromRequest(): string
    {
        return $this->request->hasArgument('searchTerm')
            ? (string)$this->request->getArgument('searchTerm')
            : '';
    }

    protected function getPaginator(QueryResultInterface $queryResult, int $resultsPerPage = 10): QueryResultPaginator
    {
        return new QueryResultPaginator(
            $queryResult,
            $this->getCurrentPageNumberFromRequest(),
            $resultsPerPage,
        );
    }
}
