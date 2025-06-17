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
use Wtl\HioTypo3Connector\Domain\Model\DoctoralProgram;
use Wtl\HioTypo3Connector\Domain\Repository\DoctoralProgramRepository;

#[AsController]
class DoctoralProgramController extends BaseController
{
    protected int $pageUid;

    public function __construct(
        protected readonly ModuleTemplateFactory     $moduleTemplateFactory,
        protected readonly DoctoralProgramRepository $doctoralProgramRepository,
        protected readonly PropertyMapper            $propertyMapper
    )
    {}

    public function indexAction(): ResponseInterface
    {
        $paginator = $this->getPaginator(
            $this->doctoralProgramRepository->findAll(),
        );
        $this->view->assignMultiple([
            'paginator' => $paginator,
            'pagination' => new SimplePagination($paginator),
            'searchWord' => $this->getSearchWordFromRequest(),
        ]);

        return $this->htmlResponse();
    }

    public function searchAction(int $currentPage = 1, string $searchWord = ''): ResponseInterface
    {
        $paginator = $this->getPaginator(
            $this->doctoralProgramRepository->findBySearchWord($searchWord),
        );
        $this->view->assignMultiple([
            'paginator' => $paginator,
            'pagination' => new SimplePagination($paginator),
            'searchWord' =>  $this->getSearchWordFromRequest(),
        ]);

        return $this->htmlResponse();
    }

    public function showAction(DoctoralProgram $doctoralProgram, string $listAction = 'index'): ResponseInterface
    {
        $this->view->assignMultiple(
            [
                'doctoralProgram' => $doctoralProgram,
                'currentPageNumber' => $this->getCurrentPageNumberFromRequest(),
                'searchWord' => $this->getSearchWordFromRequest(),
                'listAction' => $listAction,
            ]
        );
        return $this->htmlResponse();
    }
}
