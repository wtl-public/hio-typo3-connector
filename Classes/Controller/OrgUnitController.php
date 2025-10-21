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
use Wtl\HioTypo3Connector\Domain\Model\OrgUnit;
use Wtl\HioTypo3Connector\Domain\Model\Person;
use Wtl\HioTypo3Connector\Domain\Repository\CitationStyleRepository;
use Wtl\HioTypo3Connector\Domain\Repository\OrgUnitRepository;
use Wtl\HioTypo3Connector\Domain\Repository\PublicationRepository;
use Wtl\HioTypo3Connector\Services\Statistics\OrgUnitStats;

#[AsController]
class OrgUnitController extends BaseController
{
    protected int $pageUid;

    public function __construct(
        protected readonly ModuleTemplateFactory $moduleTemplateFactory,
        protected readonly OrgUnitRepository $orgUnitRepository,
        protected readonly PublicationRepository $publicationRepository,
        protected readonly CitationStyleRepository $citationStyleRepository,
        protected readonly PropertyMapper $propertyMapper,
        protected readonly LoggerInterface $logger,
        protected readonly OrgUnitStats $orgUnitStatsService,
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
            $this->orgUnitRepository->findByFilter($filter),
        );
        $this->view->assignMultiple([
            'paginator' => $paginator,
            'pagination' => new SlidingWindowPagination($paginator, 12),
            'filter' => $filter->toArray(),
        ]);

        return $this->htmlResponse();
    }

    public function initializeShowAction(): void
    {
        if ($this->request->hasArgument('orgUnitObjectId')) {
            $orgUnitObjectId = (int)$this->request->getArgument('orgUnitObjectId');
            $orgUnit = $this->orgUnitRepository->findByObjectId($orgUnitObjectId);
            if ($orgUnit instanceof OrgUnit) {
                $this->request = $this->request->withArgument('orgUnit',  $orgUnit);
            } else {
                $this->logger->error('OrgUnit with objectId ' . $orgUnitObjectId . ' not found.');
                throw new \RuntimeException('OrgUnit not found', 404);
            }
        }
        $filter = $this->getFilterFromRequest();
        $this->request = $this->request->withArgument('filter',  $filter);
    }

    public function showAction(OrgUnit $orgUnit): ResponseInterface
    {
        $this->view->assignMultiple(
            [
                'orgUnit' => $orgUnit,
                'currentPageNumber' => $this->getCurrentPageNumberFromRequest(),
                'filter' => $this->getFilterFromRequest(),
            ]
        );
        return $this->htmlResponse();
    }

    public function publicationListAction(): ResponseInterface
    {
        $orderBy = $this->settings['orderBy'] ?? '';

        /** @var OrgUnit $selectedOrgUnit */
        $selectedOrgUnit = $this->orgUnitRepository->findByUid($this->settings['orgUnitUid']);
        if ($this->settings['citationStyle'] && $this->settings['citationStyle'] !== '') {
            $citationStyleModel = $this->citationStyleRepository->findByUid($this->settings['citationStyle']);
            if($citationStyleModel) {
                $selectedCitationStyle = $citationStyleModel->getLabel();
            } else {
                $selectedCitationStyle = $this->citationStyleRepository->findAll()->getFirst()->getLabel();
            }
        } else  {
            $selectedCitationStyle = false;
        }

        if ($selectedOrgUnit) {
            $publications = $selectedOrgUnit->getPublications() ?? [];

            // get order settings from plugin configuration
            $orderings = $this->getPublicationOrderingFromProperty('orderBy');
            $orderings = array_merge($orderings, $this->getPublicationOrderingFromProperty('addOrderBy'));

            if ($orderings !== []) {
                $publications = $this->publicationRepository->getPublicationsByOrgUnit($selectedOrgUnit, $orderings);
            }

            $groupBy = $this->settings['groupBy'] ?? '';
            if ($groupBy !== '') {
                $ungroupedPublications = [];
                $groupedPublications = [];
                switch ($groupBy) {
                    case 'releaseYear':
                        foreach ($publications as $publication) {
                            if ($publication->getReleaseYear() === null) {
                                $ungroupedPublications[] = $publication;
                            } else {
                                $groupedPublications[] = $publication;
                            }
                        }
                        break;
                    case 'type':
                        foreach ($publications as $publication) {
                            if ($publication->getType() === '') {
                                $ungroupedPublications[] = $publication;
                            } else {
                                $groupedPublications[] = $publication;
                            }
                        }
                        break;
                }
            }
        }

        $this->view->assignMultiple([
            'orgUnit' => $selectedOrgUnit,
            'publications' => $publications ?? [],
            'groupedPublications' => $groupedPublications ?? [],
            'ungroupedPublications' => $ungroupedPublications ?? [],
            'selectedCitationStyle' => $selectedCitationStyle,
        ]);

        return $this->htmlResponse();
    }

    public function projectListAction(): ResponseInterface
    {
        /** @var OrgUnit $selectedOrgUnit */
        $selectedOrgUnit = $this->orgUnitRepository->findByUid($this->settings['orgUnitUid']);

        $this->view->assignMultiple([
            'orgUnit' => $selectedOrgUnit,
            'projectStatusStatistics' => $this->orgUnitStatsService->getProjectCountByStatus($selectedOrgUnit) ?? [],
        ]);

        return $this->htmlResponse();
    }

    public function patentListAction(): ResponseInterface
    {
        /** @var OrgUnit $selectedOrgUnit */
        $selectedOrgUnit = $this->orgUnitRepository->findByUid($this->settings['orgUnitUid']);

        $this->view->assignMultiple([
            'orgUnit' => $selectedOrgUnit,
        ]);

        return $this->htmlResponse();
    }
}
