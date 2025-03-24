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
use Wtl\HioTypo3Connector\Domain\Model\Habilitation;
use Wtl\HioTypo3Connector\Domain\Repository\HabilitationRepository;

#[AsController]
class HabilitationController extends BaseController
{
    protected int $pageUid;

    public function __construct(
        protected readonly ModuleTemplateFactory  $moduleTemplateFactory,
        protected readonly HabilitationRepository $habilitationRepository,
        protected readonly PropertyMapper         $propertyMapper
    )
    {}

    public function indexAction(int $currentPage = 1): ResponseInterface
    {
        $paginator = new QueryResultPaginator(
            $this->habilitationRepository->findAll(),
            $this->getCurrentPageNumberFromRequest(),
            10,
        );
        $pagination = new SimplePagination($paginator);
        $this->view->assignMultiple([
            'paginator' => $paginator,
            'pagination' => $pagination,
        ]);

        return $this->htmlResponse();
    }

    public function searchAction(int $currentPage = 1, String $searchWord = ''): ResponseInterface
    {
        $habilitations = $this->habilitationRepository->findBySearchWord($searchWord);

        $paginator = new QueryResultPaginator(
            $habilitations,
            $this->getCurrentPageNumberFromRequest(),
            10,
        );
        $pagination = new SimplePagination($paginator);
        $this->view->assignMultiple([
            'paginator' => $paginator,
            'pagination' => $pagination,
            'searchWord' => $searchWord,
        ]);

        return $this->htmlResponse();
    }

    public function showAction(Habilitation $habilitation): ResponseInterface
    {
        $this->view->assignMultiple(
            [
                'habilitation' => $habilitation,
                'currentPageNumber' => $this->getCurrentPageNumberFromRequest(),
            ]
        );
        return $this->htmlResponse();
    }
}
