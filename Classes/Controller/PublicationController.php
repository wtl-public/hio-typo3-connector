<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Pagination\SlidingWindowPagination;
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
        $orderBy = $this->settings['orderBy'] ?? '';
        $publications = [];
        if ($orderBy !== '') {
            [$propertyName, $order] = explode(':', $orderBy);
            if (in_array($propertyName, ['title', 'type', 'releaseYear'])) {
                $publications = $this->publicationRepository->getPublications([$propertyName => $order]);
            }
        } else {
            $publications = $this->publicationRepository->findAll();
        }
        $paginator = $this->getPaginator(
            $publications,
        );

        $this->view->assignMultiple([
            'paginator' => $paginator,
            'pagination' => new SlidingWindowPagination($paginator, 12),
            'searchWord' => $this->getSearchWordFromRequest(),
        ]);

        return $this->htmlResponse();
    }

    public function searchAction(int $currentPage = 1, string $searchWord = ''): ResponseInterface
    {
        $paginator = $this->getPaginator(
            $this->publicationRepository->findBySearchWord($searchWord),
        );
        $this->view->assignMultiple([
            'paginator' => $paginator,
            'pagination' => new SlidingWindowPagination($paginator, 12),
            'searchWord' => $this->getSearchWordFromRequest(),
        ]);

        return $this->htmlResponse();
    }

    public function showAction(Publication $publication, string $listAction = 'index'): ResponseInterface
    {
        $this->view->assignMultiple(
            [
                'publication' => $publication,
                'currentPageNumber' => $this->getCurrentPageNumberFromRequest(),
                'searchWord' => $this->getSearchWordFromRequest(),
                'listAction' => $listAction,
            ]
        );
        return $this->htmlResponse();
    }
}
