<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use TYPO3\CMS\Core\Pagination\SlidingWindowPagination;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Extbase\Property\PropertyMapper;
use Wtl\HioTypo3Connector\Domain\Model\OrgUnit;
use Wtl\HioTypo3Connector\Domain\Repository\OrgUnitRepository;

#[AsController]
class OrgUnitController extends BaseController
{
    protected int $pageUid;

    public function __construct(
        protected readonly ModuleTemplateFactory $moduleTemplateFactory,
        protected readonly OrgUnitRepository $orgUnitRepository,
        protected readonly PropertyMapper $propertyMapper
    )
    {}

    public function indexAction(): ResponseInterface
    {

        $paginator = $this->getPaginator(
            $this->orgUnitRepository->findAll(),
        );
        $this->view->assignMultiple([
            'paginator' => $paginator,
            'pagination' => new SlidingWindowPagination($paginator, 12),
            'searchTerm' => $this->getSearchTermFromRequest(),
        ]);

        return $this->htmlResponse();
    }

    public function searchAction(int $currentPage = 1, String $searchTerm = ''): ResponseInterface
    {
        $paginator = $this->getPaginator(
            $this->orgUnitRepository->findBySearchTerm($searchTerm),
        );
        $this->view->assignMultiple([
            'paginator' => $paginator,
            'pagination' => new SlidingWindowPagination($paginator, 12),
            'searchTerm' => $this->getSearchTermFromRequest(),
        ]);

        return $this->htmlResponse();
    }

    public function showAction(OrgUnit $orgUnit, string $listAction = 'index'): ResponseInterface
    {
        $this->view->assignMultiple(
            [
                'orgUnit' => $orgUnit,
                'currentPageNumber' => $this->getCurrentPageNumberFromRequest(),
                'searchTerm' => $this->getSearchTermFromRequest(),
                'listAction' => $listAction,
            ]
        );
        return $this->htmlResponse();
    }
}
