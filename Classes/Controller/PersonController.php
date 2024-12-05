<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Error\Http\PageNotFoundException;
use TYPO3\CMS\Core\Http\ImmediateResponseException;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Extbase\Property\PropertyMapper;
use TYPO3\CMS\Frontend\Controller\ErrorController;
use Wtl\HioTypo3Connector\Domain\Model\Person;
use Wtl\HioTypo3Connector\Domain\Repository\PersonRepository;
use Wtl\HioTypo3Connector\Domain\Repository\PublicationRepository;

#[AsController]
class PersonController extends BaseController
{
    protected int $pageUid;

    public function __construct(
        protected readonly ModuleTemplateFactory $moduleTemplateFactory,
        protected readonly PersonRepository $personRepository,
        protected readonly PropertyMapper $propertyMapper,
        protected readonly PublicationRepository $publicationRepository,
    )
    {}

    public function indexAction(int $currentPage = 1): ResponseInterface
    {
        $allAvailablePersons = $this->personRepository->findAll();

        $paginator = new QueryResultPaginator(
            $allAvailablePersons,
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
    public function showAction(?Person $person = null): ResponseInterface
    {
        if ($person === null) {
            $response = GeneralUtility::makeInstance(ErrorController::class)->pageNotFoundAction($this->request, 'Person not found');
            throw new ImmediateResponseException($response, 1234567890);
        }
        $this->view->assignMultiple(
            [
                'person' => $person,
                'currentPageNumber' => $this->getCurrentPageNumberFromRequest(),
            ]
        );
        return $this->htmlResponse();
    }

    public function publicationListAction(): ResponseInterface
    {
        $orderBy = $this->settings['orderBy'] ?? '';

        /** @var Person $selectedPerson */
        $selectedPerson = $this->personRepository->findByUid($this->settings['personUid']);

        $publications = $selectedPerson->getPublications();
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

        $this->view->assignMultiple([
            'person' => $selectedPerson,
            'publications' => $publications,
            'groupedPublications' => $groupedPublications ?? [],
            'ungroupedPublications' => $ungroupedPublications ?? [],
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
}
