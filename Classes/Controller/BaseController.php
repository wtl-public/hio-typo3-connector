<?php

namespace Wtl\HioTypo3Connector\Controller;

use Wtl\HioTypo3Connector\Controller\AbstractController;

class BaseController extends AbstractController
{
    protected function getCurrentPageNumberFromRequest(): int
    {
        return $this->request->hasArgument('currentPageNumber')
            ? (int)$this->request->getArgument('currentPageNumber')
            : 1;
    }
}
