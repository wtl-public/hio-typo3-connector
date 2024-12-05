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
use Wtl\HioTypo3Connector\Domain\Model\DTO\ProjectDTO;
use Wtl\HioTypo3Connector\Domain\Model\Project;
use Wtl\HioTypo3Connector\Domain\Repository\ProjectRepository;

#[AsController]
class ProjectController extends BaseController
{
    protected int $pageUid;

    public function __construct(
        protected readonly ModuleTemplateFactory $moduleTemplateFactory,
        protected readonly ProjectRepository $projectRepository,
        protected readonly PropertyMapper $propertyMapper
    )
    {}

    public function indexAction(int $currentPage = 1): ResponseInterface
    {
        $paginator = new QueryResultPaginator(
            $this->projectRepository->findAll(),
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

    public function showAction(Project $project): ResponseInterface
    {
        $this->view->assignMultiple(
            [
                'project' => $project,
                'currentPageNumber' => $this->getCurrentPageNumberFromRequest(),
            ]
        );
        return $this->htmlResponse();
    }
}
