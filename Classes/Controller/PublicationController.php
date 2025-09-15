<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Pagination\SlidingWindowPagination;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Extbase\Property\PropertyMapper;
use Wtl\HioTypo3Connector\Domain\Dto\Filter\PublicationFilter;
use Wtl\HioTypo3Connector\Domain\Model\Publication;
use Wtl\HioTypo3Connector\Domain\Repository\PublicationRepository;

#[AsController]
class PublicationController extends BaseController
{
    protected int $pageUid;

    public function __construct(
        protected readonly ModuleTemplateFactory $moduleTemplateFactory,
        protected readonly PublicationRepository $publicationRepository,
        protected readonly PropertyMapper $propertyMapper,
        protected readonly LoggerInterface $logger,
    )
    {}

    public function initializeIndexAction(): void
    {
        $filter = $this->getFilterFromRequest();
        $this->request = $this->request->withArgument('filter',  $filter);
    }

    public function indexAction(PublicationFilter $filter, int $currentPageNumber = 1): ResponseInterface
    {
        if ($this->request->getMethod() === 'POST') {
            if ($filter->shouldReset()) {
                $filter = $filter->resetFilter();
            }
            return $this->redirect(
                actionName: 'index',
                arguments: [
                    'currentPageNumber' => $currentPageNumber,
                    'filter' => $filter->toArray(),
                ]
            );
        }
        $orderBy = $this->settings['orderBy'] ?? '';
        $publications = [];
        if ($orderBy !== '') {
            [$propertyName, $order] = explode(':', $orderBy);
            if (in_array($propertyName, ['title', 'type', 'releaseYear'])) {
                $publications = $this->publicationRepository->findByFilter($filter, [$propertyName => $order]);
            }
        } else {
            $publications = $this->publicationRepository->findByFilter($filter);
        }
        $paginator = $this->getPaginator(
            $publications,
        );

        $typeOptions = array_map(
            fn($value) => ['value' => $value['type'], 'label' => $value['type']],
            $this->publicationRepository->getPublicationTypes() ?? []
        );
        if (!empty($typeOptions)) {
            array_unshift($typeOptions, ['value' => '', 'label' => 'Alle']);
        }
        $this->view->assignMultiple([
            'paginator' => $paginator,
            'pagination' => new SlidingWindowPagination($paginator, 12),
            'filter' => $filter->toArray(),
            'publicationTypes' => $typeOptions,
        ]);

        return $this->htmlResponse();
    }

    public function initializeShowAction(): void
    {
        $filter = $this->getFilterFromRequest();
        $this->request = $this->request->withArgument('filter',  $filter);
    }

    public function showAction(Publication $publication): ResponseInterface
    {
        $this->view->assignMultiple(
            [
                'publication' => $publication,
                'currentPageNumber' => $this->getCurrentPageNumberFromRequest(),
                'filter' => $this->getFilterFromRequest(),
            ]
        );
        return $this->htmlResponse();
    }

    public function highlightsAction()
    {
        $publicationUids = explode(',', $this->settings['publicationUids']) ?? [];
        $query = $this->publicationRepository->createQuery();
        $query->matching(
            $query->in('uid', $publicationUids)
        );
        $publications = $query->execute();
        $orderedPublications = [];
        array_map(
            function ($uid) use ($publications, &$orderedPublications) {
                foreach ($publications as $publication) {
                    if ($publication->getUid() == $uid) {
                        $orderedPublications[] = $publication;
                        break;
                    }
                }
            },
            $publicationUids
        );

        $this->view->assign('publications', $orderedPublications);
        return $this->htmlResponse();
    }

    protected function getFilterFromRequest(): PublicationFilter
    {
        $filter = new PublicationFilter();
        if ($this->request->hasArgument('filter')) {
            $filter = $this->request->getArgument('filter');
            if (! $filter instanceof PublicationFilter) {
                try {
                    $filter = PublicationFilter::fromRequest($this->request);
                }
                catch (\Throwable $e) {
                    $this->logger->error(
                        'Failed to parse filter from request: ' . $e->getMessage(),
                        ['exception' => $e]
                    );
                    $filter = new PublicationFilter();
                }
            }
        }
        return $filter;
    }
}
