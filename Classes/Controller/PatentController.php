<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Extbase\Property\PropertyMapper;
use Wtl\HioTypo3Connector\Domain\Model\Patent;
use Wtl\HioTypo3Connector\Domain\Repository\PatentRepository;

#[AsController]
class PatentController extends BaseController
{
    protected int $pageUid;

    public function __construct(
        protected readonly ModuleTemplateFactory $moduleTemplateFactory,
        protected readonly PatentRepository $patentRepository,
        protected readonly PropertyMapper $propertyMapper
    )
    {}

    public function indexAction(int $currentPage = 1): ResponseInterface
    {

        $paginator = $this->getPaginator(
            $this->patentRepository->findAll(),
        );
        $this->view->assignMultiple([
            'paginator' => $paginator,
            'pagination' => new SimplePagination($paginator),
        ]);

        return $this->htmlResponse();
    }

    public function searchAction(int $currentPage = 1, String $searchWord = ''): ResponseInterface
    {
        $paginator = $this->getPaginator(
            $this->patentRepository->findBySearchWord($searchWord),
        );
        $this->view->assignMultiple([
            'paginator' => $paginator,
            'pagination' => new SimplePagination($paginator),
            'searchWord' => $searchWord,
        ]);

        return $this->htmlResponse();
    }

    public function showAction(Patent $patent): ResponseInterface
    {
        $this->view->assignMultiple(
            [
                'patent' => $patent,
                'currentPageNumber' => $this->getCurrentPageNumberFromRequest(),
            ]
        );
        return $this->htmlResponse();
    }
}
