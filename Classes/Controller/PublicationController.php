<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Extbase\Property\PropertyMapper;
use Wtl\HioTypo3Connector\Domain\Model\Publication;
use Wtl\HioTypo3Connector\Domain\Repository\PublicationRepository;

#[AsController]
class PublicationController extends BaseController
{
    protected int $pageUid;

    public function __construct(
        protected readonly ModuleTemplateFactory $moduleTemplateFactory,
        protected readonly PublicationRepository $publicationRepository,
        protected readonly PropertyMapper $propertyMapper
    )
    {}

    public function indexAction(): ResponseInterface
    {
        $paginator = new QueryResultPaginator(
            $this->publicationRepository->findAll(),
            $this->getCurrentPageNumberFromRequest(),
            10,
        );
        $pagination = new SimplePagination($paginator);
        $pagination->getNextPageNumber();
        $pagination->getPreviousPageNumber();

        $this->view->assignMultiple([
            'paginator' => $paginator,
            'pagination' => $pagination,
        ]);

        return $this->htmlResponse();
    }

    public function showAction(Publication $publication): ResponseInterface
    {
        $this->view->assignMultiple(
            [
                'publication' => $publication,
                'currentPageNumber' => $this->getCurrentPageNumberFromRequest(),
            ]
        );
        return $this->htmlResponse();
    }
}
