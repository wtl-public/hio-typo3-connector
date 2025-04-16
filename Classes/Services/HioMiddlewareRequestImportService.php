<?php

namespace Wtl\HioTypo3Connector\Services;

use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\Log\Logger;

class HioMiddlewareRequestImportService
{
    protected array $headers;

    protected string $url;

    private RequestFactory $requestFactory;

    private Logger $logger;

    /**
     * @var array
     */
    protected $auth = [];

    protected $verifySsl = false;

    /**
     * @var int
     */
    protected int $batchSize;
    protected string $webhookUrl;
    protected string $xApiKey;

    public function __construct(RequestFactory $requestFactory)
    {
        $this->headers = ['Content-Type' => 'application/json'];
        $this->requestFactory = $requestFactory;
        $this->logger = new Logger('HioApiService');
        $this->url = ''; // configure this in the scheduler task

        $this->batchSize = 100; // configure this in the scheduler task
        $this->webhookUrl = ''; // configure this in the scheduler task
        $this->xApiKey = ''; // configure this in the scheduler task
    }

    public function configure(
        string $apiUrl,
        string $apiUsername,
        string $apiPassword,
        bool $verifySsl,
        string $webhookUrl,
        string $xApiKey,
        int $batchSize
    ): void
    {
        $this->url = $apiUrl;
        if ($apiUsername && $apiPassword) {
            $this->auth = [$apiUsername, $apiPassword];
        }
        $this->verifySsl = $verifySsl;
        $this->webhookUrl = $webhookUrl;
        $this->xApiKey = $xApiKey;
        $this->batchSize = $batchSize;
    }

    public function requestImport(string $entityType): ApiResponse{
        try {
            $response = $this->requestFactory->request($this->url, 'POST', [
                'headers' => $this->headers,
                'auth' => $this->auth,
                'verify' => $this->verifySsl,
                'json' => [
                    'type' => $entityType,
                    'webhookUrl' => $this->webhookUrl,
                    'xApiKey' => $this->xApiKey,
                    'batchSize' => $this->batchSize,
                ]
            ]);
            return $response;

        } catch (\Exception $e) {
            $this->logger->error(sprintf(
                'Error requesting data import from HIO Middleware API: %s',
                $e->getMessage()
            ));

            throw($e);
        }
    }
}
