<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Error\Http\PageNotFoundException;
use TYPO3\CMS\Core\Http\ImmediateResponseException;
use TYPO3\CMS\Core\Pagination\SlidingWindowPagination;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Extbase\Property\PropertyMapper;
use TYPO3\CMS\Frontend\Controller\ErrorController;
use Wtl\HioTypo3Connector\Domain\Model\Person;
use Wtl\HioTypo3Connector\Domain\Repository\CitationStyleRepository;
use Wtl\HioTypo3Connector\Domain\Repository\PersonRepository;
use Wtl\HioTypo3Connector\Domain\Repository\PublicationRepository;
use Wtl\HioTypo3Connector\Services\Statistics\PersonStats;

#[AsController]
class PersonController extends BaseController
{
    protected int $pageUid;

    public function __construct(
        protected readonly ModuleTemplateFactory $moduleTemplateFactory,
        protected readonly PersonRepository      $personRepository,
        protected readonly PropertyMapper        $propertyMapper,
        protected readonly PublicationRepository $publicationRepository,
        protected readonly CitationStyleRepository $citationStyleRepository,
        protected readonly PersonStats $personStatsService,
    )
    {
    }

    public function indexAction(): ResponseInterface
    {
        $paginator = $this->getPaginator(
            $this->personRepository->findAll(),
        );
        $this->view->assignMultiple([
            'paginator' => $paginator,
            'pagination' => new SlidingWindowPagination($paginator, 12),
            'searchTerm' => $this->getSearchTermFromRequest(),
        ]);

        return $this->htmlResponse();
    }

    public function searchAction(int $currentPage = 1, string $searchTerm = ''): ResponseInterface
    {
        $paginator = $this->getPaginator(
            $this->personRepository->findBySearchTerm($searchTerm),
        );
        $this->view->assignMultiple([
            'paginator' => $paginator,
            'pagination' => new SlidingWindowPagination($paginator, 12),
            'searchTerm' => $this->getSearchTermFromRequest(),
        ]);

        return $this->htmlResponse();
    }

    public function initializeShowAction(): void
    {
        // ensure the show action works with the person object_id as argument
        if ($this->request->hasArgument('person')) {
            $personArgument = trim($this->request->getArgument('person'));
            if (MathUtility::canBeInterpretedAsInteger($personArgument)) {
                $person = $this->personRepository->findOneBy(['objectId' => (int)$personArgument]);
                $this->request = $this->request->withArgument('person', $person);
            }
        }
    }

    /**
     * @throws ImmediateResponseException
     * @throws PageNotFoundException
     */
    public function showAction(?Person $person = null, string $listAction = 'index'): ResponseInterface
    {
        if ($person === null) {
            $response = GeneralUtility::makeInstance(ErrorController::class)->pageNotFoundAction($this->request, 'Person not found');
            throw new ImmediateResponseException($response, 1234567890);
        }
        $this->view->assignMultiple(
            [
                'person' => $person,
                'currentPageNumber' => $this->getCurrentPageNumberFromRequest(),
                'searchTerm' => $this->getSearchTermFromRequest(),
                'listAction' => $listAction,
                'typeStatistics' => $this->personStatsService->getPublicationTypeStats($person) ?? [],
                'coAuthorshipStatistics' => $this->personStatsService->getCoAuthorshipStats($person) ?? [],
            ]
        );
        return $this->htmlResponse();
    }

    public function publicationListAction(): ResponseInterface
    {
        $orderBy = $this->settings['orderBy'] ?? '';

        /** @var Person $selectedPerson */
        $selectedPerson = $this->personRepository->findByUid($this->settings['personUid']);

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

        if ($selectedPerson) {
            $publications = $selectedPerson->getPublications() ?? [];
            if ($orderBy !== '') {
                [$propertyName, $order] = explode(':', $orderBy);
                if (in_array($propertyName, ['title', 'type', 'releaseYear'])) {
                    $publications = $this->publicationRepository->getPublicationsByPerson($selectedPerson, [$propertyName => $order]);
                }
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
            'person' => $selectedPerson,
            'publications' => $publications ?? [],
            'groupedPublications' => $groupedPublications ?? [],
            'ungroupedPublications' => $ungroupedPublications ?? [],
            'selectedCitationStyle' => $selectedCitationStyle,
            'typeStatistics' => $this->personStatsService->getPublicationTypeStats($selectedPerson) ?? [],
            'coAuthorshipStatistics' => $this->personStatsService->getCoAuthorshipStats($selectedPerson) ?? [],
        ]);

        return $this->htmlResponse();
    }

    public function projectListAction(): ResponseInterface
    {
        /** @var Person $selectedPerson */
        $selectedPerson = $this->personRepository->findByUid($this->settings['personUid']);

        $this->view->assignMultiple([
            'person' => $selectedPerson,
        ]);

        return $this->htmlResponse();
    }

    public function patentListAction(): ResponseInterface
    {
        /** @var Person $selectedPerson */
        $selectedPerson = $this->personRepository->findByUid($this->settings['personUid']);

        $this->view->assignMultiple([
            'person' => $selectedPerson,
        ]);

        return $this->htmlResponse();
    }

    public function doctoralProgramListAction(): ResponseInterface
    {
        /** @var Person $selectedPerson */
        $selectedPerson = $this->personRepository->findByUid($this->settings['personUid']);

        $this->view->assignMultiple([
            'person' => $selectedPerson,
        ]);

        return $this->htmlResponse();
    }

    public function orgUnitListAction(): ResponseInterface
    {
        /** @var Person $selectedPerson */
        $selectedPerson = $this->personRepository->findByUid($this->settings['personUid']);

        $orgUnits = $selectedPerson->getOrgUnits() ?? [];

        $this->view->assignMultiple([
            'person' => $selectedPerson,
        ]);

        return $this->htmlResponse();
    }

    public function habilitationListAction(): ResponseInterface
    {
        /** @var Person $selectedPerson */
        $selectedPerson = $this->personRepository->findByUid($this->settings['personUid']);

        $habilitations = $selectedPerson->getHabilitations() ?? [];
        // if display only the own publications
        if ($this->settings['displayType'] && $this->settings['displayType'] == 'doctoral') {
            $ownHabilitations = [];
            foreach ($habilitations as $habilitation) {
                foreach ($habilitation->getDetails()['persons'] as $person) {
                    if ($person['id'] === $selectedPerson->getObjectId() && $person['role'] === 'doctoral') {
                        $ownHabilitations[] = $habilitation;
                    }
                }
            }
            $habilitations = $ownHabilitations;
        }

        if ($this->settings['displayType'] && $this->settings['displayType'] == 'supervisor') {
            $supervisedHabilitations = [];
            foreach ($habilitations as $habilitation) {
                foreach ($habilitation->getDetails()['persons'] as $person) {
                    if ($person['id'] === $selectedPerson->getObjectId() && $person['role'] !== 'doctoral') {
                        $supervisedHabilitations[] = $habilitation;
                    }
                }
            }
            $habilitations = $supervisedHabilitations;
        }

        $this->view->assignMultiple([
            'person' => $selectedPerson,
            'habilitations' => $habilitations,
        ]);

        return $this->htmlResponse();
    }
}
