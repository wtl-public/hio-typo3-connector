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

    protected function getSearchWordFromRequest(): string
    {
        return $this->request->hasArgument('searchWord')
            ? (string)$this->request->getArgument('searchWord')
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
