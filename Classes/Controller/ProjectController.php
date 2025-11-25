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
use Wtl\HioTypo3Connector\Domain\Dto\Filter\ProjectFilter;
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

    public function indexAction(ProjectFilter $filter, int $currentPageNumber = 1): ResponseInterface
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
            'budgetSourceTypeOptions' => $this->getProjectBudgetSourceTypeOptions(),
            'statusOptions' => $this->getProjectStatusOptions(),
            'typeOptions' => $this->getProjectTypeOptions(),
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

    public function highlightsAction()
    {
        $projectUids = explode(',', $this->settings['projectUids']) ?? [];
        $query = $this->projectRepository->createQuery();
        $query->matching(
            $query->in('uid', $projectUids)
        );
        $projects = $query->execute();
        $orderedProjects = [];
        array_map(
            function ($uid) use ($projects, &$orderedProjects) {
                foreach ($projects as $project) {
                    if ($project->getUid() == $uid) {
                        $orderedProjects[] = $project;
                        break;
                    }
                }
            },
            $projectUids
        );

        $this->view->assign('projects', $orderedProjects);
        return $this->htmlResponse();
    }

    protected function getFilterFromRequest(): ProjectFilter
    {
        $filter = new ProjectFilter();
        if ($this->request->hasArgument('filter')) {
            $filter = $this->request->getArgument('filter');
            if (! $filter instanceof ProjectFilter) {
                try {
                    $filter = ProjectFilter::fromRequest($this->request);
                }
                catch (\Throwable $e) {
                    $this->logger->error(
                        'Failed to parse filter from request: ' . $e->getMessage(),
                        ['exception' => $e]
                    );
                    $filter = new ProjectFilter();
                }
            }
        }
        return $filter;
    }

    protected function getProjectStatusOptions(): array
    {
        $options = array_map(
            fn($value) => ['value' => $value['status'], 'label' => $value['status']],
            $this->projectRepository->getProjectStatus() ?? []
        );
        if (!empty($options)) {
            array_unshift($options, ['value' => '', 'label' => 'Alle']);
        }

        return $options ?? [];
    }

    protected function getProjectTypeOptions(): array
    {
        $options = array_map(
            fn($value) => ['value' => $value['type'], 'label' => $value['type']],
            $this->projectRepository->getProjectTypes() ?? []
        );
        if (!empty($options)) {
            array_unshift($options, ['value' => '', 'label' => 'Alle']);
        }

        return $options ?? [];
    }

    protected function getProjectBudgetSourceTypeOptions(): array
    {
        $options = array_map(
            fn($value) => ['value' => $value, 'label' => $value],
            $this->projectRepository->getProjectBudgetSourceTypes() ?? []
        );

        return $options ?? [];
    }
}
