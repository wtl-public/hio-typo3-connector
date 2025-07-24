<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Services;

use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\Log\Logger;
use Psr\EventDispatcher\EventDispatcherInterface;
use Wtl\HioTypo3Connector\Publisher\ApiMeta;
use Wtl\HioTypo3Connector\Publisher\ApiResponse;

class HioApiService
{
    /**
     * @var ApiResponse
     */
    protected ApiResponse $responseBody;

    protected array $headers;

    protected string $url;

    protected int $storagePageId;

    private RequestFactory $requestFactory;

    private Logger $logger;

    /**
     * @var array
     */
    protected $auth = [];

    protected $verifySsl = false;

    public function __construct(
        RequestFactory $requestFactory,
        protected readonly EventDispatcherInterface $eventDispatcher
    )
    {
        $this->headers = ['Content-Type' => 'application/json'];
        $this->requestFactory = $requestFactory;
        $this->logger = new Logger('HioApiService');
        $this->url = ''; // configure this in the scheduler task
        $this->storagePageId = 0; // configure this in the scheduler task
    }

    public function configure(string $url, string $username, string $password, string $storagePageId, bool $verifySsl): void
    {
        $this->url = $url;
        if ($username && $password) {
            $this->auth = [$username, $password];
        }
        $this->storagePageId = (int)$storagePageId;
        $this->verifySsl = $verifySsl;
    }

    public function fetch($page=1): ApiResponse {
        $requestUrl = $this->url . '?page=' . $page;
        try {
            $response = $this->requestFactory->request($requestUrl, 'GET', [
                'headers' => $this->headers,
                'auth' => $this->auth,
                'verify' => $this->verifySsl
            ]);
            $rawJsonResponse = json_decode($response->getBody()->getContents(), true)??[];
            $this->responseBody = new ApiResponse(
                $rawJsonResponse['data']??[],
                $rawJsonResponse['meta']??[],
                $rawJsonResponse['links']??[]
            );
        } catch (\Exception $e) {
            $this->logger->error(sprintf(
                'Error while fetching projects from HIO Middleware API: %s',
                $e->getMessage()
            ));

            throw($e);
        }

        return $this->responseBody;
    }

    public function getData($page=1): array
    {
        $apiResponse = $this->fetch($page);

        if ($apiResponse->getMeta()->getTotal() === 0) {
            return [];
        }

        return $apiResponse->getData();
    }

    public function getMeta(): ApiMeta|null {
        if (!$this->responseBody) {
            return new ApiMeta();
        }
        return $this->responseBody->getMeta();
    }
}
