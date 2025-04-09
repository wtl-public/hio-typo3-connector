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
use Wtl\HioTypo3Connector\Domain\Model\Doctorate;
use Wtl\HioTypo3Connector\Domain\Repository\DoctorateRepository;

#[AsController]
class DoctorateController extends BaseController
{
    protected int $pageUid;

    public function __construct(
        protected readonly ModuleTemplateFactory $moduleTemplateFactory,
        protected readonly DoctorateRepository $doctorateRepository,
        protected readonly PropertyMapper $propertyMapper
    )
    {}

    public function indexAction(int $currentPage = 1): ResponseInterface
    {
        $paginator = $this->getPaginator(
            $this->doctorateRepository->findAll(),
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
            $this->doctorateRepository->findBySearchWord($searchWord),
        );
        $this->view->assignMultiple([
            'paginator' => $paginator,
            'pagination' => new SimplePagination($paginator),
            'searchWord' =>  $this->getSearchWordFromRequest(),
        ]);

        return $this->htmlResponse();
    }

    public function showAction(Doctorate $doctorate): ResponseInterface
    {
        $this->view->assignMultiple(
            [
                'doctorate' => $doctorate,
                'currentPageNumber' => $this->getCurrentPageNumberFromRequest(),
                'searchWord' => $this->getSearchWordFromRequest(),
            ]
        );
        return $this->htmlResponse();
    }
}
