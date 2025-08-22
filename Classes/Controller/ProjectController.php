<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use TYPO3\CMS\Core\Pagination\SlidingWindowPagination;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Extbase\Property\PropertyMapper;
use Wtl\HioTypo3Connector\Domain\Dto\Filter\FilterDto;
use Wtl\HioTypo3Connector\Domain\Model\Project;
use Wtl\HioTypo3Connector\Domain\Repository\ProjectRepository;

#[AsController]
class ProjectController extends BaseController
{
    protected int $pageUid;

    public function __construct(
        protected readonly ModuleTemplateFactory $moduleTemplateFactory,
        protected readonly ProjectRepository $projectRepository,
        protected readonly PropertyMapper $propertyMapper,
        protected readonly LoggerInterface $logger,
    )
    {}

    public function initializeIndexAction(): void
    {
        $filter = $this->getFilterFromRequest();
        $this->request = $this->request->withArgument('filter',  $filter);
    }

    public function indexAction(FilterDto $filter, int $currentPageNumber = 1): ResponseInterface
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

        $paginator = $this->getPaginator(
            $this->projectRepository->findByFilter($filter),
        );
        $this->view->assignMultiple([
            'paginator' => $paginator,
            'pagination' => new SlidingWindowPagination($paginator, 12),
            'filter' => $this->getFilterFromRequest(),
        ]);

        return $this->htmlResponse();
    }

    public function initializeShowAction(): void
    {
        $filter = $this->getFilterFromRequest();
        $this->request = $this->request->withArgument('filter',  $filter);
    }

    public function showAction(Project $project): ResponseInterface
    {
        $this->view->assignMultiple(
            [
                'project' => $project,
                'currentPageNumber' => $this->getCurrentPageNumberFromRequest(),
                'filter' => $this->getFilterFromRequest(),
            ]
        );
        return $this->htmlResponse();
    }
}
